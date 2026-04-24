<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bujk', function (Blueprint $table) {
            $table->id();
            $table->string('nib', 50)->index();
            $table->string('nama_bujk');
            $table->string('npwp_bujk', 50)->nullable()->index();
            $table->string('jenis_bujk', 100);
            $table->text('alamat_bujk')->nullable();
            $table->string('kab_kota_bujk')->nullable()->index();
            $table->string('provinsi_bujk')->nullable()->index();
            $table->string('telp_bujk', 50)->nullable();
            $table->string('email_bujk')->nullable()->index();
            $table->string('website_bujk')->nullable();
            $table->unsignedInteger('jumlah_tenaga_kerja')->nullable();
            $table->boolean('is_deleted')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bujk');
    }
};