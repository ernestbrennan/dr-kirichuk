<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\Tag\TagCollection;
use App\Models\Tag;

class TagService
{
    public function getList(Request $request)
    {
        $cities = Tag::query()->get();

        return new TagCollection($cities);
    }
}
