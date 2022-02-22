<?php

namespace App\Http\Requests\Doctor\Patient;

use App\Http\Requests\Request;

class ByIdRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|exists:patients,id'
        ];
    }

}
