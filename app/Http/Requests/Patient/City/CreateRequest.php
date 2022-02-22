<?php

namespace App\Http\Requests\Patient\City;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function rules()
    {
        return [
            'city_archive_id' => 'required|numeric|exists:cities_archive,id',
        ];
    }
}
