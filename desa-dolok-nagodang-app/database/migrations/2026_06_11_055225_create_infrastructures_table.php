<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();

            $table->string('nama_barang');
            $table->string('jenis_barang')->nullable();
            $table->string('kode_barang')->nullable();

            $table->string('jumlah_luas')->nullable();

            $table->decimal('nilai_harga', 18, 2)->nullable();

            $table->year('tahun_pengadaan')->nullable();

            $table->enum('kondisi', [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ])->default('Baik');

            $table->string('keterangan')->nullable();

            $table->string('image')->nullable();

            $table->enum('status', [
                'draft',
                'publish'
            ])->default('draft');

            $table->longText('content')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infrastructures');
    }
};