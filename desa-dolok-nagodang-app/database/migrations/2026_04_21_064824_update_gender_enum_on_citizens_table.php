<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->enum('gender_new', ['Laki-laki', 'Perempuan'])
                ->nullable()
                ->after('gender');
        });

        DB::table('citizens')
            ->where('gender', 'L')
            ->update(['gender_new' => 'Laki-laki']);

        DB::table('citizens')
            ->where('gender', 'P')
            ->update(['gender_new' => 'Perempuan']);

        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('citizens', function (Blueprint $table) {
            $table->renameColumn('gender_new', 'gender');
        });
    }

    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->enum('gender_old', ['L', 'P'])
                ->nullable()
                ->after('gender');
        });

        DB::table('citizens')
            ->where('gender', 'Laki-laki')
            ->update(['gender_old' => 'L']);

        DB::table('citizens')
            ->where('gender', 'Perempuan')
            ->update(['gender_old' => 'P']);

        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('citizens', function (Blueprint $table) {
            $table->renameColumn('gender_old', 'gender');
        });
    }
};