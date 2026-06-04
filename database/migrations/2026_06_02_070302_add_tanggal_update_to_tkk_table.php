<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tkk')) {
            return;
        }

        if (Schema::hasColumn('tkk', 'tanggal_update')) {
            return;
        }

        Schema::table('tkk', function (Blueprint $table) {
            $table->date('tanggal_update')->nullable();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('tkk')) {
            return;
        }

        if (!Schema::hasColumn('tkk', 'tanggal_update')) {
            return;
        }

        Schema::table('tkk', function (Blueprint $table) {
            $table->dropColumn('tanggal_update');
        });
    }
};