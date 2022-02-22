<?php

namespace App\Http\Requests\Patient\Applozic;

use App\Http\Requests\Request;

class DeleteMessageRequest extends Request
{
    public function rules()
    {
        return [
            'doctor_key' => 'required|string',
            'patient_key' => 'required|string',
        ];
    }
}
