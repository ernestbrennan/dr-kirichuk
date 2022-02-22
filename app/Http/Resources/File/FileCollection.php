<?php

namespace App\Http\Resources\File;

use App\Http\Resources\BaseCollection;

class FileCollection extends BaseCollection
{
    public function toArray($request)
    {
        return FileResource::collection($this->collection);
    }
}
