<?php

namespace App\Http\Requests\Doctor\Visit;

use App\Http\Requests\Request;

class ByIdRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|exists:visits,id'
        ];
    }

}
