<?php

namespace App\Services;

use App\Applozic\Facades\Applozic;
use App\Http\Requests\Request;
use App\Http\Resources\Mailing\MailingBirthdayResource;
use App\Jobs\PatientMessage;
use App\Models\File;
use App\Models\Mailing;
use App\Models\MailingLog;
use App\Models\Patient;

class MailingService
{
    public function massCreate(Request $request)
    {
        $text = $request->input('text');

        $log = MailingLog::query()->create([
            'text' => $text
        ]);

        $file = File::find($request->input('file.id'));

        $fileMeta = $file ? Applozic::uploadFile($file) : null;

        Patient::query()
            ->find(collect($request->input('patients'))->pluck('id'))
            ->each(function ($patient) use ($fileMeta, $text, $log) {
                PatientMessage::dispatch($patient, $text, $fileMeta, $log);
            });
    }

    public function birthdayGet()
    {
        return MailingBirthdayResource::make(Mailing::whereType(Mailing::TYPE_BIRTHDAY)->first());
    }

    public function birthdayCreate(Request $request)
    {
        if ($mailing = Mailing::whereType(Mailing::TYPE_BIRTHDAY)->first()) {
            $mailing->delete();
        }

        $mailing = Mailing::create([
            'type' => Mailing::TYPE_BIRTHDAY,
            'content' => $request->input('content'),
        ]);

        if ($file = File::find($request->input('file.id'))) {
            $mailing->file()->save($file);
            $mailing->file_meta = Applozic::uploadFile($file);
            $mailing->save();
        }

        return MailingBirthdayResource::make($mailing);
    }

    public function birthdayDelete()
    {
        Mailing::whereType(Mailing::TYPE_BIRTHDAY)->delete();
    }
}
