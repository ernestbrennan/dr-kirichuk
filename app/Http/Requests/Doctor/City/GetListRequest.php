<?php

namespace App\Http\Requests\Doctor\City;

use App\Http\Requests\Request;

class GetListRequest extends Request
{
    public function rules()
    {
        return [
            'search' => 'nullable|string',
        ];
    }
}
