<?php

namespace App\Http\Requests\Patient\Auth;

use App\Http\Requests\Request;

class VerifyRequest extends Request
{
    public function rules()
    {
        return [
            'code' =>  'required|exists:patients,verify_code',
        ];
    }

}
