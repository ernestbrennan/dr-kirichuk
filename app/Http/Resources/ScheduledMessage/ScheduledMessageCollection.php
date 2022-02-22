<?php

namespace App\Http\Resources\ScheduledMessage;

use App\Http\Resources\BaseCollection;

class ScheduledMessageCollection extends BaseCollection
{
    public function toArray($request)
    {
        return [
            'data' => ScheduledMessageResource::collection($this->collection),
            'pagination' => $this->simplePagination(),
        ];
    }
}
