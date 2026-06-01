<?php

namespace App\Console\Commands;

use App\Services\Bujk\BujkImportService;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportBujkSbuExcel extends Command
{
    protected $signature = 'import:bujk-sbu {file} {date?}';
    protected $description = 'Import data BUJK dan detail SBU dari file Excel ke tabel bujk dan bujk_sbu';

    public function handle(BujkImportService $importService): int
    {
        $file = (string) $this->argument('file');
        $date = $this->argument('date');

        if (!is_file($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return self::FAILURE;
        }

        try {
            $uploadedFile = new UploadedFile(
                $file,
                basename($file),
                null,
                null,
                true
            );

            $summary = $importService->import($uploadedFile);

            if (!blank($date)) {
                Storage::disk('local')->put(
                    'bujk/latest-data-date.txt',
                    Carbon::parse($date)->toDateString()
                );
            }

            $this->info('Import BUJK + SBU berhasil.');
            $this->line('Total baris Excel      : ' . number_format($summary['total_rows']));
            $this->line('BUJK unik aktif        : ' . number_format($summary['prepared_rows']));
            $this->line('SBU unik aktif         : ' . number_format($summary['prepared_sbu_rows']));
            $this->line('BUJK created/updated   : ' . number_format($summary['created']) . ' / ' . number_format($summary['updated']));
            $this->line('SBU created/updated    : ' . number_format($summary['sbu_created']) . ' / ' . number_format($summary['sbu_updated']));
            $this->line('Baris dilewati         : ' . number_format($summary['skipped']));

            foreach ($summary['errors'] ?? [] as $error) {
                $this->warn($error);
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}