<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE infrastructures
            SET tahun_pengadaan = CONCAT(tahun_pengadaan, '-01-01')
            WHERE tahun_pengadaan IS NOT NULL
        ");

        DB::statement("
            ALTER TABLE infrastructures
            MODIFY tahun_pengadaan DATE NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE infrastructures
            MODIFY tahun_pengadaan YEAR NULL
        ");
    }
};