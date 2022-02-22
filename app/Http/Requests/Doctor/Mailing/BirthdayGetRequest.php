<?php

namespace App\Http\Requests\Doctor\Mailing;

use App\Http\Requests\Request;
use App\Models\Mailing;
use Illuminate\Validation\Validator;

class BirthdayGetRequest extends Request
{
    public function rules()
    {
        return [
        ];
    }

    public function moreValidation(Validator $validator )
    {
        $validator->after(function ($validator) {
            if (!Mailing::whereType(Mailing::TYPE_BIRTHDAY)->exists()) {
                $validator->errors()->add('mailing_error', 'Not exists');
            }
        });
    }
}
