<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemanfaat_produk', function (Blueprint $table) {
            if (!Schema::hasColumn('pemanfaat_produk', 'alamat')) {
                $table->text('alamat')->nullable()->after('pengelola_pemilik_bangunan');
            }

            if (!Schema::hasColumn('pemanfaat_produk', 'kabupaten')) {
                $table->string('kabupaten')->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('pemanfaat_produk', 'provinsi')) {
                $table->string('provinsi')->nullable()->after('kabupaten');
            }
        });

        if (Schema::hasColumn('pemanfaat_produk', 'lokasi')) {
            DB::table('pemanfaat_produk')
                ->whereNull('alamat')
                ->update([
                    'alamat' => DB::raw('lokasi'),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('pemanfaat_produk', function (Blueprint $table) {
            if (Schema::hasColumn('pemanfaat_produk', 'provinsi')) {
                $table->dropColumn('provinsi');
            }

            if (Schema::hasColumn('pemanfaat_produk', 'kabupaten')) {
                $table->dropColumn('kabupaten');
            }

            if (Schema::hasColumn('pemanfaat_produk', 'alamat')) {
                $table->dropColumn('alamat');
            }
        });
    }
};