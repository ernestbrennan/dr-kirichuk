<?php

namespace App\Services;

use App\Applozic\Facades\Applozic;
use App\Http\Requests\Request;
use App\Http\Resources\Patient\Patient\PatientResource;
use App\Models\File;

class PatientService
{
    private $auth_service;
    private $file_service;

    public function __construct(PatientAuthService $auth_service, FileService $file_service)
    {
        $this->auth_service = $auth_service;
        $this->file_service = $file_service;
    }

    public function profile()
    {
        return PatientResource::make($this->auth_service->getUser());
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $data['phone'] = preg_replace("/[^0-9.]/", '', $request->get('phone'));

        $patient = $this->auth_service->getUser();
        $patient->update($data);

        $patient->avatar()->detach();

        if ($file = File::find($request->input('avatar.id'))) {
            $patient->avatar()->save($file->fresh());
        }

        if ($request->get('cities')) {
            $patient->cities()->sync(collect($request->get('cities'))->pluck('id'));
        }

        Applozic::via('patient')->updateProfile();

        return PatientResource::make($patient);
    }

    public function removeAvatar()
    {
        $patient = $this->auth_service->getUser();
        $patient->avatar()->delete();

        Applozic::via('patient')->updateProfile();
    }
}
