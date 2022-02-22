<?php

namespace App\Http\Requests\Patient\City;

use App\Http\Requests\Request;

class GetListRequest extends Request
{
    public function rules()
    {
        return [
            'search' => 'string',
        ];
    }
}
