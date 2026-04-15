<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLetterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'letter_number' => 'required|string|max:255|unique:letters,letter_number',
            'letter_type_id' => 'required|exists:letter_types,id',
            'citizen_id' => 'required|exists:citizens,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:submitted,processed,approved,rejected',
            'submission_date' => 'nullable|date',
            'approved_date' => 'nullable|date',
            'approved_by' => 'nullable|integer',
            'result_file' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}