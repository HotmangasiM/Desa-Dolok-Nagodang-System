<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCitizenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nik' => 'required|digits:16|unique:citizens,nik',
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'birth_place' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'birth_date' => 'nullable|date|before_or_equal:today',
            'religion'  => 'nullable|string|max:100',
            'education' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:50',
            'family_card_number' => 'nullable|digits:16',
            'address' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'village' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'life_status' => 'required|in:alive,deceased',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka.',
            'family_card_number.digits' => 'No. KK harus berisi tepat 16 digit angka.',
            'full_name.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            'birth_place.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
        ];
    }
}
