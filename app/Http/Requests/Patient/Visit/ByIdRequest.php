<?php

namespace App\Http\Requests\Patient\Visit;

use App\Http\Requests\Request;
use App\Services\PatientAuthService;
use Illuminate\Validation\Validator;

class ByIdRequest extends Request
{

    public function rules()
    {
        return [
            'id' => 'required|exists:visits,id'
        ];

    }

    public function moreValidation(Validator $validator )
    {
        $validator->after(function ($validator) {

            $patient = app(PatientAuthService::class)->getUser();

            if (!$patient->visits->find($this->id)) {
                $validator->errors()->add('visit_belong_error', 'This data belongs to another patient');
            }
        });
    }
}
