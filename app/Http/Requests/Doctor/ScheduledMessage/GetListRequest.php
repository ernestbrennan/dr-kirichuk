<?php

namespace App\Http\Requests\Doctor\ScheduledMessage;

use App\Http\Requests\Request;

class GetListRequest extends Request
{
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id'
        ];
    }

}
