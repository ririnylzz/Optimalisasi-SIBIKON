<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pelatihan_tkk')) {
            return;
        }

        Schema::table('pelatihan_tkk', function (Blueprint $table) {
            if (!Schema::hasColumn('pelatihan_tkk', 'tahun')) {
                $table->year('tahun')->nullable()->after('id');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'jenis_peserta')) {
                $table->string('jenis_peserta')->nullable()->after('status');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'metode_kegiatan')) {
                $table->string('metode_kegiatan')->nullable()->after('jenis_peserta');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'waktu_kegiatan')) {
                $table->date('waktu_kegiatan')->nullable()->after('metode_kegiatan');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'realisasi_peserta')) {
                $table->integer('realisasi_peserta')->nullable()->after('waktu_kegiatan');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'sumber_dana')) {
                $table->string('sumber_dana')->nullable()->after('realisasi_peserta');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'standar_kompetensi')) {
                $table->string('standar_kompetensi')->nullable()->after('sumber_dana');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'tuk')) {
                $table->string('tuk')->nullable()->after('standar_kompetensi');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'lsp')) {
                $table->string('lsp')->nullable()->after('tuk');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'tempat_kegiatan')) {
                $table->string('tempat_kegiatan')->nullable()->after('lsp');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'provinsi')) {
                $table->string('provinsi')->nullable()->after('tempat_kegiatan');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'kabupaten_kota')) {
                $table->string('kabupaten_kota')->nullable()->after('provinsi');
            }

            if (!Schema::hasColumn('pelatihan_tkk', 'syarat_tambahan')) {
                $table->text('syarat_tambahan')->nullable()->after('kabupaten_kota');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('pelatihan_tkk')) {
            return;
        }

        Schema::table('pelatihan_tkk', function (Blueprint $table) {
            $columns = [
                'tahun',
                'jenis_peserta',
                'metode_kegiatan',
                'waktu_kegiatan',
                'realisasi_peserta',
                'sumber_dana',
                'standar_kompetensi',
                'tuk',
                'lsp',
                'tempat_kegiatan',
                'provinsi',
                'kabupaten_kota',
                'syarat_tambahan',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('pelatihan_tkk', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};