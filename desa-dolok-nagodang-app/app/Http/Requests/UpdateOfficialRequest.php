<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficialRequest extends FormRequest
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'term_start' => 'nullable|date',
            'term_end' => 'nullable|date',
            'description' => 'nullable|string',
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}