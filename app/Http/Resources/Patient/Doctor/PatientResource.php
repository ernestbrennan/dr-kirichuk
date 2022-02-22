<?php

namespace App\Http\Resources\Patient\Doctor;

use App\Http\Resources\BaseResource;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\File\FileResource;
use Carbon\Carbon;

class PatientResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'avatar' => FileResource::make($this->avatar),
            'birthday' => $this->birthday ? $this->birthday->toDateTimeString() : null,
            'registered_at' => $this->registered_at ? $this->registered_at->toDateTimeString() : null,
            'last_login_at' => $this->last_login_at ? $this->last_login_at->toDateTimeString() : null,
            'last_visit_at' => $this->last_visit && $this->last_visit->date ? $this->last_visit->date->toDateTimeString() : null,
            'cities' => CityResource::collection($this->cities),
            'comment' => $this->doctor_comment ? $this->doctor_comment->content : null,
        ];
    }
}
