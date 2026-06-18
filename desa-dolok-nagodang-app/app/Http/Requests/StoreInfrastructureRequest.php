<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInfrastructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255', 'regex:/^[\pL\pN\s]+$/u'],
            'kode_barang' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\-\/]+$/'],
            'jenis_barang' => ['nullable', 'string', 'max:255', 'regex:/^[\pL\pN\s]+$/u'],
            'jumlah_luas' => ['nullable', 'string', 'max:255', 'regex:/^[\pL\pN\s]+$/u'],
            'nilai_harga' => ['nullable', 'numeric', 'min:0'],
            'tahun_pengadaan' => ['nullable', 'integer', 'digits:4', 'min:1900', 'max:' . now()->year],
            'kondisi' => ['required', Rule::in(['Baik', 'Rusak Ringan', 'Rusak Berat'])],
            'keterangan' => ['nullable', Rule::in(['ADD', 'DD', 'HIBAH', 'SUMBANGAN'])],
            'status' => ['required', Rule::in(['draft', 'publish'])],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.regex' => 'Nama Barang hanya boleh berisi huruf, angka, dan spasi.',
            'kode_barang.regex' => 'Kode Barang hanya boleh berisi huruf, angka, spasi, tanda hubung, dan garis miring.',
            'jenis_barang.regex' => 'Jenis Barang hanya boleh berisi huruf, angka, dan spasi.',
            'jumlah_luas.regex' => 'Jumlah atau Luas hanya boleh berisi huruf, angka, dan spasi.',
            'tahun_pengadaan.max' => 'Tahun pengadaan tidak boleh melebihi tahun berjalan.',
            'tahun_pengadaan.min' => 'Tahun pengadaan tidak valid.',
            'nilai_harga.min' => 'Nilai atau harga tidak boleh kurang dari 0.',
        ];
    }
}
