<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use RuntimeException;
use ZipArchive;

class SimpleSpreadsheetReader
{
    // Membaca file spreadsheet (CSV/TXT/XLSX) sesuai format
    public function read(string $absolutePath, ?string $originalName = null): array
    {
        $extension = strtolower(pathinfo($originalName ?: $absolutePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'csv', 'txt' => $this->readCsv($absolutePath),
            'xlsx' => $this->readXlsx($absolutePath),
            default => throw new RuntimeException('Format file belum didukung. Gunakan file CSV atau XLSX.'),
        };
    }

    // Membaca file CSV/TXT menjadi array
    protected function readCsv(string $path): array
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('File CSV tidak dapat dibuka.');
        }

        $delimiter = $this->detectCsvDelimiter($path);
        $rows = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = array_map([$this, 'sanitizeCsvCell'], $row);
        }

        fclose($handle);

        return $this->rowsToAssociativeRows($rows);
    }

    // Membaca file XLSX (Excel) dan memilih sheet terbaik
    protected function readXlsx(string $path): array
    {
        if (!class_exists(ZipArchive::class) || !class_exists(DOMDocument::class)) {
            throw new RuntimeException('Import XLSX membutuhkan ekstensi PHP zip dan xml aktif di server.');
        }

        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            throw new RuntimeException('File XLSX tidak dapat dibuka.');
        }

        try {
            $sharedStrings = $this->readSharedStrings($zip);
            $sheets = $this->readSheets($zip);
            $bestRows = [];
            $bestHeaderCount = 0;
            $bestDataCount = 0;

            foreach ($sheets as $sheet) {
                $xml = $zip->getFromName($sheet['path']);

                if (!is_string($xml) || trim($xml) === '') {
                    continue;
                }

                $rows = $this->parseWorksheetRows($xml, $sharedStrings);
                $mapped = $this->rowsToAssociativeRowsWithMeta($rows);

                if ($mapped['header_count'] === 0 || empty($mapped['rows'])) {
                    continue;
                }

                $currentDataCount = count($mapped['rows']);
                $isBetterSheet = $mapped['header_count'] > $bestHeaderCount
                    || ($mapped['header_count'] === $bestHeaderCount && $currentDataCount > $bestDataCount);

                if ($isBetterSheet) {
                    $bestRows = $mapped['rows'];
                    $bestHeaderCount = $mapped['header_count'];
                    $bestDataCount = $currentDataCount;
                }
            }

            return $bestRows;
        } finally {
            $zip->close();
        }
    }

    // Membaca shared string dari file XLSX
    protected function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');

        if (!is_string($xml) || trim($xml) === '') {
            return [];
        }

        $xpath = $this->createXPath($xml);

        if (!$xpath instanceof DOMXPath) {
            return [];
        }

        $values = [];
        $stringItems = $xpath->query('//*[local-name()="si"]');

        if ($stringItems === false) {
            return [];
        }

        foreach ($stringItems as $item) {
            $values[] = $this->collectTextNodes($xpath, './/*[local-name()="t"]', $item);
        }

        return $values;
    }

    // Membaca daftar sheet dan relasinya di XLSX
    protected function readSheets(ZipArchive $zip): array
    {
        $workbookXml = $zip->getFromName('xl/workbook.xml');
        $relationsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');

        if (!is_string($workbookXml) || !is_string($relationsXml)) {
            return [];
        }

        $workbookXPath = $this->createXPath($workbookXml);
        $relationsXPath = $this->createXPath($relationsXml);

        if (!$workbookXPath instanceof DOMXPath || !$relationsXPath instanceof DOMXPath) {
            return [];
        }

        $relationshipMap = [];
        $relationshipNodes = $relationsXPath->query('//*[local-name()="Relationship"]');

        if ($relationshipNodes !== false) {
            foreach ($relationshipNodes as $relation) {
                if (!$relation instanceof DOMElement) {
                    continue;
                }

                $id = $this->getAttributeValue($relation, 'Id');
                $target = $this->getAttributeValue($relation, 'Target');

                if ($id !== null && $target !== null) {
                    $relationshipMap[$id] = $this->normalizeZipPath($target);
                }
            }
        }

        $sheets = [];
        $sheetNodes = $workbookXPath->query('//*[local-name()="sheets"]/*[local-name()="sheet"]');

        if ($sheetNodes === false) {
            return [];
        }

        foreach ($sheetNodes as $sheet) {
            if (!$sheet instanceof DOMElement) {
                continue;
            }

            $relationshipId = $this->getAttributeValue($sheet, 'id');
            $sheetName = $this->getAttributeValue($sheet, 'name') ?? 'Sheet';

            if ($relationshipId && isset($relationshipMap[$relationshipId])) {
                $sheets[] = [
                    'name' => $sheetName,
                    'path' => $relationshipMap[$relationshipId],
                ];
            }
        }

        return $sheets;
    }

    // Parsing baris worksheet menjadi array
    protected function parseWorksheetRows(string $xml, array $sharedStrings): array
    {
        $xpath = $this->createXPath($xml);

        if (!$xpath instanceof DOMXPath) {
            return [];
        }

        $rows = [];
        $rowNodes = $xpath->query('//*[local-name()="sheetData"]/*[local-name()="row"]');

        if ($rowNodes === false) {
            return [];
        }

        foreach ($rowNodes as $rowNode) {
            if (!$rowNode instanceof DOMElement) {
                continue;
            }

            $row = [];
            $cellNodes = $xpath->query('./*[local-name()="c"]', $rowNode);

            if ($cellNodes === false) {
                continue;
            }

            foreach ($cellNodes as $cell) {
                if (!$cell instanceof DOMElement) {
                    continue;
                }

                $reference = $this->getAttributeValue($cell, 'r') ?? '';
                $columnLetters = preg_replace('/\d+/', '', $reference);

                if ($columnLetters === '') {
                    continue;
                }

                $columnIndex = $this->columnLettersToIndex($columnLetters);
                $row[$columnIndex] = $this->readCellValue($xpath, $cell, $sharedStrings);
            }

            if (!empty($row)) {
                $rows[] = $this->expandSparseRow($row);
            }
        }

        return $rows;
    }

    // Membaca nilai cell pada worksheet
    protected function readCellValue(DOMXPath $xpath, DOMElement $cell, array $sharedStrings): ?string
    {
        $type = $this->getAttributeValue($cell, 't');

        if ($type === 'inlineStr') {
            $inlineText = $this->collectTextNodes($xpath, './/*[local-name()="t"]', $cell);

            return $inlineText === '' ? null : $inlineText;
        }

        $valueNodes = $xpath->query('./*[local-name()="v"]', $cell);
        $valueNode = ($valueNodes !== false && $valueNodes->length > 0) ? $valueNodes->item(0) : null;
        $rawValue = $valueNode instanceof DOMNode ? trim($valueNode->textContent) : null;

        if ($rawValue === null || $rawValue === '') {
            return null;
        }

        if ($type === 's') {
            return $sharedStrings[(int) $rawValue] ?? null;
        }

        return $rawValue;
    }

    // Mengubah rows menjadi associative array
    protected function rowsToAssociativeRows(array $rows): array
    {
        return $this->rowsToAssociativeRowsWithMeta($rows)['rows'];
    }

    // Mengubah rows menjadi associative array lengkap dengan metadata header
    protected function rowsToAssociativeRowsWithMeta(array $rows): array
    {
        $headerInfo = $this->detectHeaderRow($rows);

        if ($headerInfo === null) {
            return [
                'rows' => [],
                'header_count' => 0,
            ];
        }

        $headerMap = $headerInfo['header_map'];
        $headerRowIndex = $headerInfo['header_row_index'];
        $results = [];

        foreach (array_slice($rows, $headerRowIndex + 1) as $offset => $row) {
            if ($this->rowIsEmpty($row)) {
                continue;
            }

            $record = ['__row_number' => $headerRowIndex + $offset + 2];

            foreach ($headerMap as $columnIndex => $field) {
                $record[$field] = isset($row[$columnIndex]) ? $this->sanitizeSpreadsheetCell($row[$columnIndex]) : null;
            }

            $results[] = $record;
        }

        return [
            'rows' => $results,
            'header_count' => count(array_unique($headerMap)),
        ];
    }

    // Mendeteksi baris header pada spreadsheet
    protected function detectHeaderRow(array $rows): ?array
    {
        foreach ($rows as $rowIndex => $row) {
            $headerMap = [];

            foreach ($row as $columnIndex => $cellValue) {
                $resolved = $this->resolveHeaderAlias($cellValue);

                if ($resolved !== null) {
                    $headerMap[$columnIndex] = $resolved;
                }
            }

            if (count(array_unique($headerMap)) >= 3) {
                return [
                    'header_row_index' => $rowIndex,
                    'header_map' => $headerMap,
                ];
            }
        }

        return null;
    }

    // Mengubah label header menjadi field standar
    protected function resolveHeaderAlias(mixed $value): ?string
    {
        $normalized = strtolower(trim((string) $value));
        $normalized = preg_replace('/[^a-z0-9]+/i', '_', $normalized ?? '');
        $normalized = trim((string) $normalized, '_');

        foreach (config('bujk.header_aliases', []) as $field => $aliases) {
            foreach ($aliases as $alias) {
                $aliasNormalized = strtolower(trim((string) $alias));
                $aliasNormalized = preg_replace('/[^a-z0-9]+/i', '_', $aliasNormalized ?? '');
                $aliasNormalized = trim((string) $aliasNormalized, '_');

                if ($normalized === $aliasNormalized) {
                    return $field;
                }
            }
        }

        return null;
    }

    // Mengecek apakah row kosong
    protected function rowIsEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if ($this->sanitizeSpreadsheetCell($cell) !== null) {
                return false;
            }
        }

        return true;
    }

    // Membersihkan cell spreadsheet
    protected function sanitizeSpreadsheetCell(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $cleaned = preg_replace('/\s+/', ' ', trim((string) $value));

        return $cleaned === '' ? null : $cleaned;
    }

    // Membersihkan cell CSV
    protected function sanitizeCsvCell(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);

        return $value === '' ? null : $value;
    }

    // Deteksi delimiter CSV
    protected function detectCsvDelimiter(string $path): string
    {
        $firstLine = '';
        $handle = fopen($path, 'rb');

        if ($handle !== false) {
            $firstLine = (string) fgets($handle);
            fclose($handle);
        }

        $delimiters = [',', ';', "\t", '|'];
        $selected = ',';
        $selectedScore = 0;

        foreach ($delimiters as $delimiter) {
            $score = substr_count($firstLine, $delimiter);

            if ($score > $selectedScore) {
                $selected = $delimiter;
                $selectedScore = $score;
            }
        }

        return $selected;
    }

    // Mengubah sparse row menjadi full row
    protected function expandSparseRow(array $row): array
    {
        ksort($row);
        $maxIndex = max(array_keys($row));
        $expanded = array_fill(0, $maxIndex + 1, null);

        foreach ($row as $columnIndex => $value) {
            $expanded[$columnIndex] = $value;
        }

        return $expanded;
    }

    // Mengubah huruf kolom Excel menjadi index angka
    protected function columnLettersToIndex(string $columnLetters): int
    {
        $letters = strtoupper($columnLetters);
        $index = 0;

        for ($position = 0; $position < strlen($letters); $position++) {
            $index = ($index * 26) + (ord($letters[$position]) - 64);
        }

        return max(0, $index - 1);
    }

    // Membuat XPath dari XML
    protected function createXPath(string $xml): ?DOMXPath
    {
        $cleanXml = preg_replace('/^\xEF\xBB\xBF/', '', $xml);
        $dom = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $loaded = $dom->loadXML($cleanXml);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (!$loaded) {
            return null;
        }

        return new DOMXPath($dom);
    }

    // Mengambil semua text node
    protected function collectTextNodes(DOMXPath $xpath, string $expression, ?DOMNode $contextNode = null): string
    {
        $nodes = $xpath->query($expression, $contextNode);

        if ($nodes === false || $nodes->length === 0) {
            return '';
        }

        $textParts = [];

        foreach ($nodes as $node) {
            $textParts[] = $node->textContent;
        }

        return trim(preg_replace('/\s+/u', ' ', implode('', $textParts)));
    }

    // Mengambil atribut XML
    protected function getAttributeValue(DOMElement $element, string $attributeName): ?string
    {
        if ($element->hasAttribute($attributeName)) {
            $value = trim($element->getAttribute($attributeName));

            return $value === '' ? null : $value;
        }

        foreach ($element->attributes as $attribute) {
            if ($attribute->localName === $attributeName || $attribute->nodeName === $attributeName) {
                $value = trim($attribute->nodeValue ?? '');

                return $value === '' ? null : $value;
            }
        }

        return null;
    }

    // Normalisasi path ZIP Excel
    protected function normalizeZipPath(string $target): string
    {
        $target = str_replace('\\', '/', trim($target));

        if ($target === '') {
            return '';
        }

        if (str_starts_with($target, '/')) {
            return ltrim($target, '/');
        }

        $combined = str_starts_with($target, 'xl/') ? $target : 'xl/' . ltrim($target, '/');
        $parts = [];

        foreach (explode('/', $combined) as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                array_pop($parts);
                continue;
            }

            $parts[] = $segment;
        }

        return implode('/', $parts);
    }
}