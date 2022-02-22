<?php

namespace App\Http\Resources\Notification;

use App\Http\Resources\BaseResource;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\Patient\Doctor\PatientResource;

class NotificationResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
            'patient' => PatientResource::make($this->patient),
//            'content' => trans('notification.'.$this->type, $this->patient->toArray()),
        ];
    }
}
