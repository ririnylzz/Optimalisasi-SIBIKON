<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Migration lama ini sebelumnya mengubah:
         * - kab_kota_bujk
         * - provinsi_bujk
         *
         * menjadi TEXT.
         *
         * Di MySQL, kolom TEXT tidak bisa tetap dipakai sebagai index tanpa panjang key,
         * sehingga migration gagal dengan error:
         * BLOB/TEXT column used in key specification without a key length.
         *
         * Karena struktur BUJK sekarang sudah dipindahkan ke kolom spreadsheet baru:
         * - kabupaten
         * - propinsi
         *
         * maka migration lama ini sengaja dibuat no-op agar proses migration bisa lanjut
         * ke migration rebuild BUJK terbaru.
         */
    }

    public function down(): void
    {
        //
    }
};