<?php

namespace App\Http\Resources\Notification;

use App\Http\Resources\BaseCollection;

class NotificationCollection extends BaseCollection
{
    public function toArray($request)
    {
        return [
            'data' => NotificationResource::collection($this->collection),
            'pagination' => $this->simplePagination(),
        ];
    }
}
