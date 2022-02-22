<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\BaseCollection;

class TagCollection extends BaseCollection
{
    public function toArray($request)
    {
        return TagResource::collection($this->collection);
    }
}
