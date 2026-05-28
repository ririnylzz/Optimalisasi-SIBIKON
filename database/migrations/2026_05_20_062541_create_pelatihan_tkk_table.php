<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelatihan_tkk', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kegiatan');
            $table->string('jabatan_kerja')->nullable();

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->string('tempat')->nullable();
            $table->string('lokasi')->nullable();

            $table->integer('peserta')->default(0);

            $table->enum('status', [
                'draft',
                'dibuka',
                'selesai'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_tkk');
    }
};