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
                'nullable',
                'string',
                'max:255',
                Rule::unique('letters', 'letter_number')->ignore($letterId),
            ],
            'letter_type_id' => 'required|exists:letter_types,id',
            'citizen_id' => 'required|exists:citizens,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payload' => 'nullable|array',
            'status' => 'required|in:submitted,processed,completed',
            'submission_date' => 'nullable|date|date_equals:today',
            'result_file' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $payload = $this->input('payload', []);

            if (!is_array($payload)) {
                return;
            }

            $letterOnlyFields = [
                'child_name' => ['label' => 'Nama anak', 'max' => 255],
                'child_gender' => ['label' => 'Jenis kelamin anak', 'max' => 50],
                'child_job' => ['label' => 'Pekerjaan anak', 'max' => 100],
                'child_religion' => ['label' => 'Agama anak', 'max' => 100],
                'business_name' => ['label' => 'Usaha pokok', 'max' => 255],
                'business_type' => ['label' => 'Usaha tambahan', 'max' => 255],
                'father_name' => ['label' => 'Nama ayah', 'max' => 255],
                'mother_name' => ['label' => 'Nama ibu', 'max' => 255],
                'guardian_name' => ['label' => 'Nama orang tua wali', 'max' => 255],
            ];

            foreach ($letterOnlyFields as $field => $config) {
                $value = $payload[$field] ?? null;

                if ($value !== null && $value !== '' && (mb_strlen((string) $value) > $config['max'] || !preg_match('/^[\pL\s]+$/u', (string) $value))) {
                    $validator->errors()->add("payload.{$field}", "{$config['label']} hanya boleh berisi huruf dan spasi.");
                }
            }

            $limitedTextFields = [
                'child_birth' => 'TTL anak',
                'child_address' => 'Alamat anak',
            ];

            foreach ($limitedTextFields as $field => $label) {
                $value = $payload[$field] ?? null;

                if ($value !== null && $value !== '' && (mb_strlen((string) $value) > 255 || !preg_match('/^[\pL\pN\s,.\-\/]+$/u', (string) $value))) {
                    $validator->errors()->add("payload.{$field}", "{$label} hanya boleh berisi huruf, angka, spasi, koma, titik, garis miring, dan strip.");
                }
            }
        });
    }
}
