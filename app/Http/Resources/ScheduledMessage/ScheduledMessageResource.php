<?php

namespace App\Http\Resources\ScheduledMessage;

use App\Http\Resources\BaseResource;
use App\Http\Resources\File\FileResource;

class ScheduledMessageResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'date' => $this->date,
        ];
    }
}
