<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'item_code' => 'required|string|max:255|unique:assets,item_code',
            'category' => ['nullable', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|in:good,damaged',
            'location' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'source' => ['nullable', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'asset_value' => 'nullable|numeric',
            'asset_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.regex' => 'Nama Barang hanya boleh berisi huruf dan spasi.',
            'category.regex' => 'Kategori hanya boleh berisi huruf dan spasi.',
            'source.regex' => 'Sumber hanya boleh berisi huruf dan spasi.',
        ];
    }
}
