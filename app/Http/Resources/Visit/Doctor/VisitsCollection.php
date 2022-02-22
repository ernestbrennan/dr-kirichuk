<?php

namespace App\Http\Resources\Visit\Doctor;

use App\Http\Resources\BaseCollection;

class VisitsCollection extends BaseCollection
{
    public function toArray($request)
    {
        return [
            'data' => VisitResource::collection($this->collection),
            'pagination' => $this->simplePagination(),
        ];
    }
}
