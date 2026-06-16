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
            'nama_barang' => ['required', 'string', 'max:255'],
            'kode_barang' => ['nullable', 'string', 'max:255'],
            'jenis_barang' => ['nullable', 'string', 'max:255'],
            'jumlah_luas' => ['nullable', 'string', 'max:255'],
            'nilai_harga' => ['nullable', 'numeric', 'min:0'],
            'tahun_pengadaan' => ['nullable', 'integer', 'digits:4', 'min:1900', 'max:' . now()->year],
            'kondisi' => ['required', Rule::in(['Baik', 'Rusak Ringan', 'Rusak Berat'])],
            'keterangan' => ['nullable', Rule::in(['ADD', 'DD', 'HIBAH', 'SUMBANGAN'])],
            'status' => ['required', Rule::in(['draft', 'publish'])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_pengadaan.max' => 'Tahun pengadaan tidak boleh melebihi tahun berjalan.',
            'tahun_pengadaan.min' => 'Tahun pengadaan tidak valid.',
            'nilai_harga.min' => 'Nilai atau harga tidak boleh kurang dari 0.',
        ];
    }
}
