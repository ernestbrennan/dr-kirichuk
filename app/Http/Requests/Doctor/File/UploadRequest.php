<?php

namespace App\Http\Requests\Doctor\File;

use App\Http\Requests\Request;

class UploadRequest extends Request
{
    public function rules()
    {
        return [
            'file' => 'file'
        ];
    }
}
