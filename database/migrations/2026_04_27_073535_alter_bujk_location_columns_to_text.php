<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE bujk MODIFY kab_kota_bujk TEXT NULL');
        DB::statement('ALTER TABLE bujk MODIFY provinsi_bujk TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE bujk MODIFY kab_kota_bujk VARCHAR(255) NULL');
        DB::statement('ALTER TABLE bujk MODIFY provinsi_bujk VARCHAR(255) NULL');
    }
};