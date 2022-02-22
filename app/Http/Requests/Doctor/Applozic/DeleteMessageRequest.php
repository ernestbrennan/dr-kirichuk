<?php

namespace App\Http\Requests\Doctor\Applozic;

use App\Http\Requests\Request;

class DeleteMessageRequest extends Request
{
    public function rules()
    {
        return [
            'doctor_key' => 'required|string',
            'patient_key' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
        ];
    }
}
