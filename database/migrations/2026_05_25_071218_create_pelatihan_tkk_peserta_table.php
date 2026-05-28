<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelatihan_tkk_peserta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelatihan_tkk_id')
                ->constrained('pelatihan_tkk')
                ->cascadeOnDelete();

            $table->string('nama');
            $table->string('nik')->nullable();

            $table->string('email')->nullable();
            $table->string('telp')->nullable();

            $table->string('pendidikan_jurusan')->nullable();

            $table->enum('asn', ['Ya', 'Tidak'])->default('Tidak');

            $table->string('jabatan_instansi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kab_kota')->nullable();

            $table->dateTime('waktu_daftar')->nullable();

            $table->string('status_peserta')->default('Calon Peserta');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelatihan_tkk_peserta');
    }
};