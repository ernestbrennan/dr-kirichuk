<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\BaseResource;

class TagResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
