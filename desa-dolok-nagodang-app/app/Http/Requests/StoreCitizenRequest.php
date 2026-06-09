<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'education' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\pN\s]+$/u'],
            'occupation' => ['nullable', 'string', 'max:100', 'not_regex:/\pN/u'],
            'marital_status' => 'nullable|string|max:50',
            'family_card_number' => 'nullable|digits:16',
            'address' => [
                'nullable',
                'string',
                Rule::in([
                    'Dusun I Dolok Nagodang',
                    'Dusun II Lumban Lintong',
                    'Dusun III Sosor Silobu',
                ]),
            ],
            'rt' => 'nullable|digits_between:1,3',
            'rw' => 'nullable|digits_between:1,3',
            'village' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'district' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'regency' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'province' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'postal_code' => 'nullable|digits:5',
            'phone' => 'nullable|digits_between:10,20',
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
            'education.regex' => 'Pendidikan hanya boleh berisi huruf, angka, dan spasi.',
            'occupation.not_regex' => 'Pekerjaan tidak boleh berisi angka.',
            'address.in' => 'Alamat harus dipilih dari daftar dusun yang tersedia.',
            'rt.digits_between' => 'RT hanya boleh berisi angka maksimal 3 digit.',
            'rw.digits_between' => 'RW hanya boleh berisi angka maksimal 3 digit.',
            'village.regex' => 'Desa hanya boleh berisi huruf dan spasi.',
            'district.regex' => 'Kecamatan hanya boleh berisi huruf dan spasi.',
            'regency.regex' => 'Kabupaten hanya boleh berisi huruf dan spasi.',
            'province.regex' => 'Provinsi hanya boleh berisi huruf dan spasi.',
            'postal_code.digits' => 'Kode Pos harus berisi tepat 5 digit angka.',
            'phone.digits_between' => 'No. HP hanya boleh berisi angka dengan panjang 10 sampai 20 digit.',
            'email.email' => 'Email harus mengandung tanda @ dan menggunakan format email yang valid.',
        ];
    }
}
