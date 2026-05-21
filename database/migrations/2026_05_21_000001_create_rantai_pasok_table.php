<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rantai_pasok', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable()->index();
            $table->string('bidang_usaha')->nullable()->index();
            $table->text('alamat')->nullable();
            $table->string('kabupaten')->nullable()->index();
            $table->string('provinsi')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rantai_pasok');
    }
};
