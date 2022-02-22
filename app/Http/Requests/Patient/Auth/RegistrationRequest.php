<?php

namespace App\Http\Requests\Patient\Auth;

use App\Http\Requests\Request;

class RegistrationRequest extends Request
{
    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'max:255',
            'cities' => 'array',
            'cities.*.id' => 'exists:cities,id',
            'avatar.id' => 'exists:files,id',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
