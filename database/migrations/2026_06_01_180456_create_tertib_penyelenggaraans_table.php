<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tertib_penyelenggaraan', function (Blueprint $table) {
            $table->id();
            $table->string('paket_pekerjaan');
            $table->string('penyedia');
            $table->string('nomor_kontrak');
            $table->date('awal_kerja')->nullable();
            $table->date('akhir_kerja')->nullable();
            $table->json('dokumen_pengawasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tertib_penyelenggaraan');
    }
};