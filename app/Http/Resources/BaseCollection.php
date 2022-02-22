<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    protected function simplePagination()
    {
        return [
            'total' => (integer) $this->total(),
            'count' => (integer) $this->count(),
            'page' => (integer) $this->currentPage(),
            'per_page' => (integer) $this->perPage(),
            'total_pages' => (integer) $this->lastPage()
        ];
    }
}
