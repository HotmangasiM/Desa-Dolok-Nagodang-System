<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLetterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $letterId = $this->route('letter');

        return [
            'letter_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('letters', 'letter_number')->ignore($letterId),
            ],
            'letter_type_id' => 'required|exists:letter_types,id',
            'citizen_id' => 'required|exists:citizens,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payload' => 'nullable|array',
            'status' => 'required|in:submitted,processed,approved,rejected',
            'submission_date' => 'nullable|date',
            'result_file' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}