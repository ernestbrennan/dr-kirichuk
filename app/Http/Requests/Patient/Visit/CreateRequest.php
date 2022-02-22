<?php

namespace App\Http\Requests\Patient\Visit;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function rules()
    {
        return [
            'date' => 'required|string',
        ];
    }
}
