<?php

namespace App\Services;

use App\Applozic\Facades\Applozic;
use App\Http\Requests\Request;
use App\Models\Doctor;
use App\Models\File;
use App\Models\Notification;
use App\Models\Patient;
use App\Notifications\Auth\VerifyPhoneCodeNotification;
use App\Notifications\Doctor\PatientRegistered;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class PatientAuthService
{
    private $guard;
    private $file_service;

    public function __construct(FileService $file_service)
    {
        $this->guard = Auth::guard('patient');
        $this->file_service = $file_service;
    }

    public function login(Request $request)
    {
        $phone =  preg_replace("/[^0-9.]/", '', $request->get('phone'));

        $patient = Patient::getByPhone($phone);

        if (!$patient) {
            $patient = Patient::create(['phone' => $phone]);
        }

        $patient->update(['verify_code' => $this->generateUniqueCode()]);

        try {
            $patient->notify(new VerifyPhoneCodeNotification($patient));
        } catch (\Exception $exception) {

        }

        return $patient;
    }

    public function generateUniqueCode()
    {
        $code = rand(1000, 9999);

        if (Patient::query()->where('verify_code', $code)->exists()) {
            return $this->generateUniqueCode();
        }

        return $code;
    }

    public function getUser()
    {
        return $this->guard->user();
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function register(Request $request)
    {
        $patient = $this->getUser();

        $patient->update(array_merge($request->all(), [
            'registered_at' => Carbon::now()->toDateTimeString(),
        ]));

        if ($file = File::find($request->input('avatar.id'))) {
            $patient->avatar()->detach();
            $patient->avatar()->save($file->fresh());
        }

        if ($request->get('cities')) {
            $patient->cities()->sync(collect($request->get('cities'))->pluck('id'));
        }

        $token = $this->guard->login($patient);

        try {
            Applozic::via('patient')->updateProfile();

            Applozic::via('doctor')->sendMessage($patient->id, 'Мы приветствуем вас в приложении Доктор Киричук. Здесь мы сможем фиксировать ваши процедуры, Календарь визитов, легко и удобно связаться с администраторами для записи, получать информацию о графике работы и новых выгодных акциях. А также присылать отчёт и вопросы в личный чат. Вы можете самостоятельно заполнить вашу карту процедур о предыдущих визитах. Либо сообщить администраторам - они это сделают за вас. Мы рады, что Вы с нами.');

            Notification::create([
                'type' => Notification::TYPE_PATIENT_REGISTERED,
                'patient_id' => $patient->id
            ]);
        } catch (\Exception $exception){

        }

        if ($patient->birthday && $patient->birthday->isToday()) {
            Notification::create([
                'type' => Notification::TYPE_PATIENT_BIRTHDAY,
                'patient_id' => $patient->id
            ]);
        }

        Doctor::first()->notify(new PatientRegistered($patient));

        return $token;
    }

    public function verify(Request $request)
    {
        $patient = Patient::getByVerifyCode($request->get('code'));
        $patient->update(['verify_code' => null, 'last_login_at' => now()]);
        $token = $this->guard->login($patient);

        return $token;
    }
}
