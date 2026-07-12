<?php

namespace App\Http\Requests;

class UpdateInfrastructureRequest extends StoreInfrastructureRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        return $rules;
    }
}
