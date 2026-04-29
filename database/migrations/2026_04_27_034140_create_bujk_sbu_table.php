<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bujk_sbu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bujk_id')->nullable()->constrained('bujk')->nullOnDelete();
            $table->string('nib', 50)->nullable()->index();
            $table->string('nama_bujk')->nullable()->index();
            $table->string('kab_kota')->nullable()->index();
            $table->string('bentuk_usaha')->nullable();
            $table->string('jenis_usaha')->nullable()->index();
            $table->string('sifat')->nullable()->index();
            $table->string('klasifikasi')->nullable()->index();
            $table->text('sub_klasifikasi')->nullable();
            $table->string('asosiasi')->nullable()->index();
            $table->string('lsbu_penerbit')->nullable()->index();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_masa_berlaku')->nullable();
            $table->date('tanggal_update')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bujk_sbu');
    }
};