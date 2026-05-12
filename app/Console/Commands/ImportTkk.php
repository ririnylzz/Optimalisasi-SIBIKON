<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Tkk;

class ImportTkk extends Command
{
    protected $signature = 'import:tkk';
    protected $description = 'Import data TKK dari Excel';

    public function handle()
    {
        $filePath = storage_path('app/imports/tkk_data.xlsx');

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unset($rows[0]); // hapus header

        foreach ($rows as $row) {

            Tkk::create([
                'nama' => $row[0],
                'kabupaten' => $row[1],
                'klasifikasi' => $row[2],
                'jabatan_kerja' => $row[3],
                'jenjang' => $row[4],
                'asosiasi' => $row[5],
                'tanggal_aktif' => $row[6],
                'tanggal_kadaluwarsa' => $row[7],
            ]);
        }

        $this->info('Import berhasil!');
    }
}