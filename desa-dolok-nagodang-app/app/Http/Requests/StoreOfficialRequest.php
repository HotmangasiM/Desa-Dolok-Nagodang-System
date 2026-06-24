<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfficialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'term_start' => 'nullable|date',
            'term_end' => 'nullable|date|after_or_equal:term_start',
            'description' => 'nullable|string',
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'photo.required' => 'Foto wajib diunggah.',
            'term_end.after_or_equal' => 'Selesai masa jabatan tidak boleh sebelum mulai masa jabatan.',
            'sort_order.min' => 'Urutan tampil tidak boleh kurang dari 0.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('term_end') && !$this->filled('term_start')) {
                $validator->errors()->add(
                    'term_end',
                    'Selesai masa jabatan hanya dapat diisi jika mulai masa jabatan sudah diisi.'
                );
            }
        });
    }
}
