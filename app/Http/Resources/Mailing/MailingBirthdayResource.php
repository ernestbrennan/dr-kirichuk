<?php

namespace App\Http\Resources\Mailing;

use App\Http\Resources\BaseResource;
use App\Http\Resources\File\FileResource;

class MailingBirthdayResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'content' => $this->content,
            'date' => $this->date,
            'file' => FileResource::make($this->file)
        ];
    }
}
