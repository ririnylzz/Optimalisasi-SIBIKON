<?php

namespace App\Console\Commands;

use App\Models\Tkk;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportTkk extends Command
{
    protected $signature = 'import:tkk {--fresh : Kosongkan tabel tkk sebelum import}';

    protected $description = 'Import data TKK dari Excel';

    public function handle()
    {
        $filePath = storage_path('app/imports/tkk_data.xlsx');

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return Command::FAILURE;
        }

        if ($this->option('fresh')) {
            Tkk::truncate();
            $this->info('Tabel tkk dikosongkan terlebih dahulu.');
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);

        unset($rows[0]); // hapus header

        $imported = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $nama = $this->cleanText($row[0] ?? null);

            if (!$nama) {
                $skipped++;
                continue;
            }

            Tkk::create([
                'nama' => $nama,
                'kabupaten' => $this->cleanText($row[1] ?? null),
                'klasifikasi' => $this->cleanText($row[2] ?? null),
                'jabatan_kerja' => $this->cleanText($row[3] ?? null),
                'jenjang' => $this->cleanNumber($row[4] ?? null),
                'asosiasi' => $this->cleanText($row[5] ?? null),
                'tanggal_aktif' => $this->normalizeDate($row[6] ?? null),
                'tanggal_kadaluwarsa' => $this->normalizeDate($row[7] ?? null),
            ]);

            $imported++;
        }

        $this->info('Import berhasil!');
        $this->info("Data masuk: {$imported}");
        $this->info("Data dilewati: {$skipped}");

        return Command::SUCCESS;
    }

    private function cleanText($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function cleanNumber($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    private function normalizeDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}