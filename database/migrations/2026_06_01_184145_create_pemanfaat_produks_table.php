<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemanfaat_produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bangunan');
            $table->string('pengelola_pemilik_bangunan')->nullable();
            $table->text('lokasi')->nullable();
            $table->string('nama_pengelola_pemilik')->nullable();
            $table->year('tahun_anggaran')->nullable();
            $table->string('kontak')->nullable();
            $table->boolean('is_deleted')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemanfaat_produk');
    }
};