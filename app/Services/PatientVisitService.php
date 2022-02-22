<?php

namespace App\Services;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Visit\Patient\VisitResource;
use App\Http\Resources\Visit\Patient\VisitsCollection;
use App\Http\Requests\Request;
use App\Models\Comment;
use App\Models\File;
use App\Models\Visit;

class PatientVisitService
{
    private $auth_service;
    private $file_service;

    public function __construct(PatientAuthService $auth_service, FileService $file_service)
    {
        $this->auth_service = $auth_service;
        $this->file_service = $file_service;
    }

    public function getById(Request $request)
    {
        return VisitResource::make(Visit::find($request->get('id')));
    }

    public function getList(Request $request)
    {
        $patient = $this->auth_service->getUser();
        $visits = Visit::where('patient_id', $patient->id)->orderBy('date', 'desc')->paginate($request->get('per_page'));

        return new VisitsCollection($visits);
    }

    public function create(Request $request)
    {
        $patient = $this->auth_service->getUser();

        $visit = $patient->visits()->create([
            'date' => $request->get('date'),
            'prescription' => $request->get('prescription'),
            'recommendation' => $request->get('recommendation'),
        ]);

        if ($content = $request->input('doctor_comment.content')) {
            $visit->doctor_comment()->create([
                'content' => $content,
                'type' => Comment::TYPE_VISIT_DOCTOR
            ]);
        }

        if ($visit->doctor_comment) {
            $visit->doctor_comment->files()->saveMany(
                File::find(collect($request->input('doctor_comment.files'))->pluck('id'))
            );
        }

        if ($request->get('private_comment')) {
            $visit->patient_private_comment()->create([
                'content' => $request->get('private_comment'),
                'type' => Comment::TYPE_VISIT_PATIENT_PRIVATE
            ]);
        }

        return VisitResource::make($visit);
    }

    public function privateComment(Request $request)
    {
        $visit = Visit::find($request->get('id'));
        $comment = $request->get('comment', null);

        if (!$comment) {
            $visit->patient_private_comment()->delete();
        } else {
            $visit->patient_private_comment()->updateOrCreate([
                'type' => Comment::TYPE_VISIT_PATIENT_PRIVATE
            ], [
                'content' => $request->get('comment'),
            ]);
        }

        return VisitResource::make($visit);
    }

    public function addFile(Request $request)
    {
        $visit = Visit::find($request->get('id'));
        $file = $visit->doctor_comment->files()->create($this->file_service->save($request->file('file')));

        return FileResource::make($file);
    }
}
