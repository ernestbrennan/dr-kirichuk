<?php

namespace App\Http\Requests\Doctor\Notification;

use App\Http\Requests\Request;

class ReadRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|exists:notifications,id'
        ];
    }
}
