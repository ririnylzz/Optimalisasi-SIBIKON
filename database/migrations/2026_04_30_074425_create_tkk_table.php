<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkkTable extends Migration
{
    public function up(): void
    {
        Schema::create('tkk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kabupaten')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('jabatan_kerja')->nullable();
            $table->unsignedTinyInteger('jenjang')->nullable();
            $table->string('asosiasi')->nullable();
            $table->date('tanggal_aktif')->nullable();
            $table->date('tanggal_kadaluwarsa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tkk');
    }
}