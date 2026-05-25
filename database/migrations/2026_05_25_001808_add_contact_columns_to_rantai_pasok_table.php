<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rantai_pasok', function (Blueprint $table) {
            if (!Schema::hasColumn('rantai_pasok', 'kontak')) {
                $table->string('kontak')->nullable()->after('provinsi');
            }

            if (!Schema::hasColumn('rantai_pasok', 'email')) {
                $table->string('email')->nullable()->after('kontak');
            }

            if (!Schema::hasColumn('rantai_pasok', 'website')) {
                $table->string('website')->nullable()->after('email');
            }

            if (!Schema::hasColumn('rantai_pasok', 'is_deleted')) {
                $table->boolean('is_deleted')->default(false)->index()->after('website');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rantai_pasok', function (Blueprint $table) {
            foreach (['kontak', 'email', 'website', 'is_deleted'] as $column) {
                if (Schema::hasColumn('rantai_pasok', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};