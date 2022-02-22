<?php

namespace App\Http\Requests\Patient\Visit;

use App\Http\Requests\Request;
use App\Models\Visit;
use App\Services\PatientAuthService;
use Illuminate\Validation\Validator;

class AddFileRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|exists:visits,id',
            'file' => 'file'

        ];
    }

    public function moreValidation(Validator $validator )
    {
        $validator->after(function ($validator) {

            $patient = app(PatientAuthService::class)->getUser();

            if (!$patient->visits->find($this->id)) {
                $validator->errors()->add('visit_belong_error', 'This visit belongs to another patient');
            }

            if (!Visit::find($this->id)->doctor_comment) {
                $validator->errors()->add('doctor_comment_empty_error', 'Doctor comment is empty');
            }
        });
    }

}
