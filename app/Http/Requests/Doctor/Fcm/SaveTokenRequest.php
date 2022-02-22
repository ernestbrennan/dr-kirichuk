<?php

namespace App\Http\Requests\Doctor\Fcm;

use App\Http\Requests\Request;

class SaveTokenRequest extends Request
{
    public function rules()
    {
        return [
            'token' => 'required|string',
        ];
    }
}
