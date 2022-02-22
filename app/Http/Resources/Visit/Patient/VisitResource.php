<?php

namespace App\Http\Resources\Visit\Patient;

use App\Http\Resources\BaseResource;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\File\FileCollection;

class VisitResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'prescription' => $this->prescription,
            'recommendation' => $this->recommendation,
            'date' => $this->date ? $this->date->toDateTimeString() : null,
            'doctor_comment' => $this->doctor_comment ? [
                'content' => $this->doctor_comment ? $this->doctor_comment->content : null,
                'files' => $this->doctor_comment ? new FileCollection($this->doctor_comment->files) : null
            ] : null,
            'private_comment' => $this->patient_private_comment ? $this->patient_private_comment->content : null,
        ];
    }
}
