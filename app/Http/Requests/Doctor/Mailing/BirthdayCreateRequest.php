<?php

namespace App\Http\Requests\Doctor\Mailing;

use App\Http\Requests\Request;
use App\Models\ScheduledMessage;
use App\Services\PatientAuthService;
use Illuminate\Validation\Validator;

class BirthdayCreateRequest extends Request
{
    public function rules()
    {
        return [
        ];
    }
}
