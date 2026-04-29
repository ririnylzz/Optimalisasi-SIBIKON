<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportBujkSbuExcel extends Command
{
    protected $signature = 'import:bujk-sbu {file} {date}';
    protected $description = 'Import data BUJK dan SBU dari file Excel';

    public function handle(): int
    {
        $file = $this->argument('file');
        $date = $this->argument('date');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return self::FAILURE;
        }

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getSheetByName('BUJK (DATABASE)');

        if (!$sheet) {
            $this->error('Sheet BUJK (DATABASE) tidak ditemukan.');
            return self::FAILURE;
        }

        $rows = $sheet->toArray(null, true, true, true);

        DB::beginTransaction();

        try {
            DB::table('bujk_sbu')
                ->whereDate('snapshot_date', $date)
                ->delete();

            foreach ($rows as $index => $row) {
                if ($index < 5) continue;

                $namaBujk = $this->clean($row['A'] ?? null);
                $nib = $this->clean($row['B'] ?? null);
                $kabKota = $this->clean($row['C'] ?? null);
                $bentukUsaha = $this->clean($row['D'] ?? null);
                $jenisUsaha = $this->clean($row['E'] ?? null);
                $sifat = $this->clean($row['F'] ?? null);
                $klasifikasi = $this->clean($row['G'] ?? null);
                $subKlasifikasi = $this->clean($row['H'] ?? null);
                $asosiasi = $this->clean($row['I'] ?? null);
                $lsbuPenerbit = $this->clean($row['J'] ?? null);

                if (!$namaBujk && !$nib) continue;

                $bujkId = DB::table('bujk')->updateOrInsert(
                    ['nib' => $nib],
                    [
                        'nama_bujk' => $namaBujk ?? '-',
                        'jenis_bujk' => $jenisUsaha ?? '-',
                        'alamat_bujk' => '-',
                        'kab_kota_bujk' => $kabKota,
                        'provinsi_bujk' => 'Kalimantan Timur',
                        'is_deleted' => false,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $bujk = DB::table('bujk')->where('nib', $nib)->first();

                DB::table('bujk_sbu')->insert([
                    'bujk_id' => $bujk?->id,
                    'nib' => $nib,
                    'nama_bujk' => $namaBujk,
                    'kab_kota' => $kabKota,
                    'bentuk_usaha' => $bentukUsaha,
                    'jenis_usaha' => $jenisUsaha,
                    'sifat' => $sifat,
                    'klasifikasi' => $klasifikasi,
                    'sub_klasifikasi' => $subKlasifikasi,
                    'asosiasi' => $asosiasi,
                    'lsbu_penerbit' => $lsbuPenerbit,
                    'tanggal_terbit' => $this->date($row['K'] ?? null),
                    'tanggal_masa_berlaku' => $this->date($row['L'] ?? null),
                    'tanggal_update' => $this->date($row['M'] ?? null),

                    'snapshot_date' => $date,
                    'source_file' => basename($file),

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            $this->info('Import BUJK dan SBU berhasil.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }

    private function clean($value): ?string
    {
        if ($value === null) return null;

        $value = trim(str_replace(["\n", "\r"], ' ', (string) $value));
        return $value === '' ? null : preg_replace('/\s+/', ' ', $value);
    }

    private function date($value): ?string
    {
        if (!$value) return null;

        try {
            if (is_numeric($value)) {
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}