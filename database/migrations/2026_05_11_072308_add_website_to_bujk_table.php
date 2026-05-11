<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bujk')) {
            return;
        }

        Schema::table('bujk', function (Blueprint $table): void {
            if (!Schema::hasColumn('bujk', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
        });

        if (Schema::hasColumn('bujk', 'website_bujk') && Schema::hasColumn('bujk', 'website')) {
            DB::statement("UPDATE bujk SET website = COALESCE(NULLIF(website, ''), website_bujk)");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('bujk')) {
            return;
        }

        Schema::table('bujk', function (Blueprint $table): void {
            if (Schema::hasColumn('bujk', 'website')) {
                $table->dropColumn('website');
            }
        });
    }
};