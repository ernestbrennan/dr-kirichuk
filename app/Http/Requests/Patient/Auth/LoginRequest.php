<?php

namespace App\Http\Requests\Patient\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'phone' => 'required',
        ];
    }
}
