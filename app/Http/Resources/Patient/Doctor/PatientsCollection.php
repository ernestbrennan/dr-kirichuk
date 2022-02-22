<?php

namespace App\Http\Resources\Patient\Doctor;

use App\Http\Resources\BaseCollection;

class PatientsCollection extends BaseCollection
{
    public function toArray($request)
    {
        return [
            'data' => PatientResource::collection($this->collection),
            'pagination' => $this->simplePagination(),
        ];
    }
}
