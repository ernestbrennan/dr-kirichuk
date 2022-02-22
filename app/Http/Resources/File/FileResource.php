<?php

namespace App\Http\Resources\File;

use App\Http\Resources\BaseResource;

class FileResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
        ];
    }
}
