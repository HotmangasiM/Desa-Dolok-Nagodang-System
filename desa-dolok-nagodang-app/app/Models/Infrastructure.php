<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Infrastructure extends Model
{
    protected $fillable = [
        'slug',

        'kecamatan',
        'desa',

        'nama_barang',
        'jenis_barang',
        'kode_barang',

        'jumlah_luas',
        'nilai_harga',
        'tahun_pengadaan',

        'kondisi',
        'keterangan',

        'image',
        'status',
        'content',
    ];

    protected $casts = [
        'nilai_harga' => 'decimal:2',
        'tahun_pengadaan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->slug) && !empty($item->nama_barang)) {
                $item->slug = Str::slug(
                    $item->nama_barang . '-' . time()
                );
            }
        });

        static::updating(function ($item) {
            if (empty($item->slug) && !empty($item->nama_barang)) {
                $item->slug = Str::slug(
                    $item->nama_barang . '-' . time()
                );
            }
        });
    }
}
