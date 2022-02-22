<?php

namespace App\Http\Requests\Patient\Profile;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:patients,phone,' . auth()->id(),
            'birthday' => 'required|string',
            'cities' => 'array',
            'cities.*.id' => 'exists:cities,id',
            'avatar.id' => 'exists:files,id',
        ];
    }
}
