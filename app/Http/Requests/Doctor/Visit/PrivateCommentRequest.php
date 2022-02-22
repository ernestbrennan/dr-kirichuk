<?php

namespace App\Http\Requests\Doctor\Visit;

use App\Http\Requests\Request;
use App\Services\PatientAuthService;
use Illuminate\Validation\Validator;

class PrivateCommentRequest extends Request
{

    public function rules()
    {
        return [
            'id' => 'required|exists:visits,id',
            'comment' => 'string|nullable'
        ];

    }
}
