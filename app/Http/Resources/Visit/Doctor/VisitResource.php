<?php

namespace App\Http\Resources\Visit\Doctor;

use App\Http\Resources\BaseResource;
use App\Http\Resources\File\FileCollection;
use App\Http\Resources\ScheduledMessage\ScheduledMessageResource;
use App\Http\Resources\Tag\TagCollection;

class VisitResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'prescription' => $this->prescription,
            'recommendation' => $this->recommendation,
            'date' => $this->date ? $this->date->toDateTimeString() : null,
            'doctor_comment' => $this->doctor_comment ? [
                'content' => $this->doctor_comment ? $this->doctor_comment->content : null,
                'files' => $this->doctor_comment ? new FileCollection($this->doctor_comment->files) : null
            ] : null,
            'private_comment' => $this->doctor_private_comment ? $this->doctor_private_comment->content : null,
            'scheduled_message' =>  ScheduledMessageResource::make($this->scheduled_message),
            'tags' =>  new TagCollection($this->tags),
        ];
    }
}
