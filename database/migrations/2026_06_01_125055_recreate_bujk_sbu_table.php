<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bujk_sbu') && Schema::hasColumn('bujk_sbu', 'sbu_signature')) {
            return;
        }

        Schema::dropIfExists('bujk_sbu');

        Schema::create('bujk_sbu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bujk_id')->nullable()->constrained('bujk')->nullOnDelete();

            $table->string('id_izin')->nullable()->index();
            $table->string('nib', 50)->nullable()->index();
            $table->string('normalized_nib', 50)->nullable()->index();
            $table->string('sbu_signature', 64)->unique();

            $table->string('npwp', 50)->nullable()->index();
            $table->string('asosiasi')->nullable()->index();
            $table->string('nama_bu')->nullable()->index();
            $table->string('bentuk_usaha')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('email')->nullable()->index();
            $table->string('website')->nullable();
            $table->string('faksimili', 50)->nullable();
            $table->string('propinsi')->nullable()->index();
            $table->string('kabupaten')->nullable()->index();

            $table->string('jenis_usaha')->nullable()->index();
            $table->string('sifat')->nullable()->index();
            $table->string('kbli_bener', 50)->nullable()->index();
            $table->string('kbli_inputan', 50)->nullable()->index();
            $table->text('ket_kbli')->nullable();
            $table->string('bentuk_badan_usaha')->nullable();
            $table->string('klasifikasi')->nullable()->index();
            $table->string('kode_subklasifikasi', 50)->nullable()->index();
            $table->text('subklasifikasi')->nullable();
            $table->string('id_kualifikasi', 50)->nullable()->index();
            $table->string('pelaksana_sertifikasi')->nullable()->index();
            $table->dateTime('tanggal_ditetapkan')->nullable()->index();
            $table->dateTime('tanggal_masa_berlaku')->nullable()->index();
            $table->string('valid', 50)->nullable()->index();
            $table->dateTime('tgl_update')->nullable()->index();
            $table->string('status', 50)->nullable()->index();

            $table->boolean('is_deleted')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bujk_sbu');
    }
};