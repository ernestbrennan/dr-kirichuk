<?php

namespace App\Http\Requests\Doctor\Patient;

use App\Http\Requests\Request;

class GetListRequest extends Request
{
    public function rules()
    {
        return [
//            'filters' => 'array',
//            'filters.first_name' => 'string',
//            'filters.last_name' => 'string',
//            'filters.phone' => 'string',
        ];
    }

}
