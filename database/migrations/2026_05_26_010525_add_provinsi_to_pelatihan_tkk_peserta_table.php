<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pelatihan_tkk_peserta')) {
            return;
        }

        Schema::table('pelatihan_tkk_peserta', function (Blueprint $table) {
            if (!Schema::hasColumn('pelatihan_tkk_peserta', 'provinsi')) {
                $table->string('provinsi')->nullable()->after('alamat');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('pelatihan_tkk_peserta')) {
            return;
        }

        Schema::table('pelatihan_tkk_peserta', function (Blueprint $table) {
            if (Schema::hasColumn('pelatihan_tkk_peserta', 'provinsi')) {
                $table->dropColumn('provinsi');
            }
        });
    }
};