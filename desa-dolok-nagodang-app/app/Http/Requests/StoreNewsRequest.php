<?php

namespace App\Http\Requests;

use App\Support\NewsContentSanitizer;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date|after_or_equal:today',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'content' => NewsContentSanitizer::sanitize($this->input('content')),
        ]);
    }

    public function messages(): array
    {
        return [
            'image.image' => 'Thumbnail harus berupa file gambar.',
            'image.mimes' => 'Thumbnail hanya boleh menggunakan format JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran thumbnail maksimal 2MB.',
            'published_at.after_or_equal' => 'Tanggal diunggah tidak boleh menggunakan tanggal sebelum hari ini.',
        ];
    }
}
