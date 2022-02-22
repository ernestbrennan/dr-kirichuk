<?php

namespace App\Http\Resources\City;

use App\Http\Resources\BaseResource;

class CityResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
