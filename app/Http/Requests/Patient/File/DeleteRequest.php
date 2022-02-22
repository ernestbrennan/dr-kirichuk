<?php

namespace App\Http\Requests\Patient\File;

use App\Http\Requests\Request;

class DeleteRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|exists:files,id'
        ];
    }
}
