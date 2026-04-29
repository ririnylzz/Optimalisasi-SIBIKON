<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bujk_sbu', function (Blueprint $table) {
            $table->date('snapshot_date')->nullable()->index();
            $table->string('source_file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bujk_sbu', function (Blueprint $table) {
            $table->dropColumn(['snapshot_date', 'source_file']);
        });
    }
};