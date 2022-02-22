<?php

namespace App\Http\Requests\Patient\City;

use App\Http\Requests\Request;

class GetArchiveListRequest extends Request
{
    public function rules()
    {
        return [
            'search' => 'string',
        ];
    }
}
