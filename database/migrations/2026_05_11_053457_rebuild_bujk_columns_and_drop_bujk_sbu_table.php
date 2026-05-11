<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('bujk_sbu');

        if (!Schema::hasTable('bujk')) {
            return;
        }

        $this->addMissingBujkColumns();
        $this->copyOldColumnsToNewColumns();
        $this->dropOldBujkColumns();
    }

    public function down(): void
    {
        // Struktur baru mengikuti spreadsheet BUJK, jadi rollback tidak membuat ulang tabel bujk_sbu.
    }

    private function addMissingBujkColumns(): void
    {
        $columns = [
            'id_izin' => fn (Blueprint $table) => $table->string('id_izin')->nullable()->index()->after('id'),
            'nib' => fn (Blueprint $table) => $table->string('nib', 50)->nullable()->index()->after('id_izin'),
            'npwp' => fn (Blueprint $table) => $table->string('npwp', 50)->nullable()->index()->after('nib'),
            'asosiasi' => fn (Blueprint $table) => $table->string('asosiasi')->nullable()->index()->after('npwp'),
            'nama_bu' => fn (Blueprint $table) => $table->string('nama_bu')->nullable()->index()->after('asosiasi'),
            'bentuk_usaha' => fn (Blueprint $table) => $table->string('bentuk_usaha')->nullable()->after('nama_bu'),
            'alamat' => fn (Blueprint $table) => $table->text('alamat')->nullable()->after('bentuk_usaha'),
            'telepon' => fn (Blueprint $table) => $table->string('telepon', 50)->nullable()->after('alamat'),
            'email' => fn (Blueprint $table) => $table->string('email')->nullable()->index()->after('telepon'),
            'faksimili' => fn (Blueprint $table) => $table->string('faksimili', 50)->nullable()->after('email'),
            'propinsi' => fn (Blueprint $table) => $table->string('propinsi')->nullable()->index()->after('faksimili'),
            'kabupaten' => fn (Blueprint $table) => $table->string('kabupaten')->nullable()->index()->after('propinsi'),
            'jenis_usaha' => fn (Blueprint $table) => $table->string('jenis_usaha')->nullable()->index()->after('kabupaten'),
            'sifat' => fn (Blueprint $table) => $table->string('sifat')->nullable()->index()->after('jenis_usaha'),
            'kbli_bener' => fn (Blueprint $table) => $table->string('kbli_bener', 50)->nullable()->index()->after('sifat'),
            'kbli_inputan' => fn (Blueprint $table) => $table->string('kbli_inputan', 50)->nullable()->index()->after('kbli_bener'),
            'ket_kbli' => fn (Blueprint $table) => $table->text('ket_kbli')->nullable()->after('kbli_inputan'),
            'bentuk_badan_usaha' => fn (Blueprint $table) => $table->string('bentuk_badan_usaha')->nullable()->after('ket_kbli'),
            'klasifikasi' => fn (Blueprint $table) => $table->string('klasifikasi')->nullable()->index()->after('bentuk_badan_usaha'),
            'kode_subklasifikasi' => fn (Blueprint $table) => $table->string('kode_subklasifikasi', 50)->nullable()->index()->after('klasifikasi'),
            'subklasifikasi' => fn (Blueprint $table) => $table->text('subklasifikasi')->nullable()->after('kode_subklasifikasi'),
            'id_kualifikasi' => fn (Blueprint $table) => $table->string('id_kualifikasi', 50)->nullable()->index()->after('subklasifikasi'),
            'pelaksana_sertifikasi' => fn (Blueprint $table) => $table->string('pelaksana_sertifikasi')->nullable()->index()->after('id_kualifikasi'),
            'tanggal_ditetapkan' => fn (Blueprint $table) => $table->dateTime('tanggal_ditetapkan')->nullable()->index()->after('pelaksana_sertifikasi'),
            'tanggal_masa_berlaku' => fn (Blueprint $table) => $table->dateTime('tanggal_masa_berlaku')->nullable()->index()->after('tanggal_ditetapkan'),
            'valid' => fn (Blueprint $table) => $table->string('valid', 50)->nullable()->index()->after('tanggal_masa_berlaku'),
            'tgl_update' => fn (Blueprint $table) => $table->dateTime('tgl_update')->nullable()->index()->after('valid'),
            'nama_pjbu' => fn (Blueprint $table) => $table->string('nama_pjbu')->nullable()->after('tgl_update'),
            'nik_pjbu' => fn (Blueprint $table) => $table->string('nik_pjbu', 50)->nullable()->after('nama_pjbu'),
            'npwp_pjbu' => fn (Blueprint $table) => $table->string('npwp_pjbu', 50)->nullable()->after('nik_pjbu'),
            'jenis_perubahan' => fn (Blueprint $table) => $table->string('jenis_perubahan', 50)->nullable()->after('npwp_pjbu'),
            'last_perubahan_at' => fn (Blueprint $table) => $table->dateTime('last_perubahan_at')->nullable()->after('jenis_perubahan'),
            'deskripsi_klasifikasi' => fn (Blueprint $table) => $table->text('deskripsi_klasifikasi')->nullable()->after('last_perubahan_at'),
            'status' => fn (Blueprint $table) => $table->string('status', 50)->nullable()->index()->after('deskripsi_klasifikasi'),
            'negara_asal' => fn (Blueprint $table) => $table->string('negara_asal')->nullable()->after('status'),
            'nama_pjtbu' => fn (Blueprint $table) => $table->string('nama_pjtbu')->nullable()->after('negara_asal'),
            'nama_pjskbu' => fn (Blueprint $table) => $table->string('nama_pjskbu')->nullable()->after('nama_pjtbu'),
            'nama_pjskbu_2' => fn (Blueprint $table) => $table->string('nama_pjskbu_2')->nullable()->after('nama_pjskbu'),
            'id_asosiasi' => fn (Blueprint $table) => $table->string('id_asosiasi', 50)->nullable()->index()->after('nama_pjskbu_2'),
        ];

        foreach ($columns as $column => $callback) {
            if (!Schema::hasColumn('bujk', $column)) {
                Schema::table('bujk', $callback);
            }
        }
    }

    private function copyOldColumnsToNewColumns(): void
    {
        $pairs = [
            'nama_bujk' => 'nama_bu',
            'npwp_bujk' => 'npwp',
            'jenis_bujk' => 'jenis_usaha',
            'alamat_bujk' => 'alamat',
            'kab_kota_bujk' => 'kabupaten',
            'provinsi_bujk' => 'propinsi',
            'telp_bujk' => 'telepon',
            'email_bujk' => 'email',
        ];

        foreach ($pairs as $oldColumn => $newColumn) {
            if (Schema::hasColumn('bujk', $oldColumn) && Schema::hasColumn('bujk', $newColumn)) {
                DB::statement("UPDATE bujk SET {$newColumn} = COALESCE(NULLIF({$newColumn}, ''), {$oldColumn})");
            }
        }
    }

    private function dropOldBujkColumns(): void
    {
        $oldColumns = [
            'nama_bujk',
            'npwp_bujk',
            'jenis_bujk',
            'alamat_bujk',
            'kab_kota_bujk',
            'provinsi_bujk',
            'telp_bujk',
            'email_bujk',
            'website_bujk',
            'jumlah_tenaga_kerja',
        ];

        $columnsToDrop = array_values(array_filter(
            $oldColumns,
            fn (string $column): bool => Schema::hasColumn('bujk', $column)
        ));

        if (!empty($columnsToDrop)) {
            Schema::table('bujk', function (Blueprint $table) use ($columnsToDrop): void {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};