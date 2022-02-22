<?php

namespace App\Http\Resources\City;

use App\Http\Resources\BaseCollection;

class CityCollection extends BaseCollection
{
    public function toArray($request)
    {
        return [
            'data' => CityResource::collection($this->collection),
        ];
    }
}
