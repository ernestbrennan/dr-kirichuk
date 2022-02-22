<?php

namespace App\Http\Requests\Doctor\ScheduledMessage;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id'
        ];
    }

}
