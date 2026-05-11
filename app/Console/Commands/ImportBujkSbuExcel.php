<?php

namespace App\Console\Commands;

use App\Models\Bujk;
use App\Support\BujkDataNormalizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportBujkSbuExcel extends Command
{
    protected $signature = 'import:bujk-sbu {file} {date?}';
    protected $description = 'Import data BUJK dari file Excel ke tabel bujk';

    public function handle(BujkDataNormalizer $normalizer): int
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return self::FAILURE;
        }

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getSheetByName('Sheet1') ?? $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);

        $header = collect($rows[0] ?? [])
            ->map(fn ($value) => $this->normalizeHeader($value))
            ->all();

        if (!in_array('nib', $header, true) || !in_array('nama_bu', $header, true)) {
            $this->error('Header Sheet1 tidak sesuai format BUJK. Pastikan ada kolom nib dan nama_bu.');
            return self::FAILURE;
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach (array_slice($rows, 1) as $row) {
                $raw = [];

                foreach ($header as $index => $field) {
                    if ($field) {
                        $raw[$field] = $row[$index] ?? null;
                    }
                }

                $record = $normalizer->normalizeImportedRow($raw);

                if (blank($record['nib'] ?? null) || blank($record['nama_bu'] ?? null)) {
                    $skipped++;
                    continue;
                }

                $existing = null;

                if (!blank($record['id_izin'] ?? null)) {
                    $existing = Bujk::query()->where('id_izin', $record['id_izin'])->first();
                }

                if (!$existing) {
                    $query = Bujk::query()->where('nib', $record['nib']);

                    if (!blank($record['kode_subklasifikasi'] ?? null)) {
                        $query->where('kode_subklasifikasi', $record['kode_subklasifikasi']);
                    }

                    if (!blank($record['subklasifikasi'] ?? null)) {
                        $query->where('subklasifikasi', $record['subklasifikasi']);
                    }

                    $existing = $query->first();
                }

                if ($existing) {
                    $existing->fill($record + ['is_deleted' => false]);
                    $existing->save();
                    $updated++;
                    continue;
                }

                Bujk::query()->create($record + ['is_deleted' => false]);
                $created++;
            }

            DB::commit();
            $this->info("Import BUJK berhasil. Created: {$created}, updated: {$updated}, skipped: {$skipped}.");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }

    private function normalizeHeader(mixed $value): ?string
    {
        $normalized = strtolower(trim((string) $value));
        $normalized = preg_replace('/[^a-z0-9]+/i', '_', $normalized ?? '');
        $normalized = trim((string) $normalized, '_');

        return $normalized === '' ? null : $normalized;
    }
}