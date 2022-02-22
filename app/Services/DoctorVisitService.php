<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\Visit\Doctor\VisitResource;
use App\Http\Resources\Visit\Doctor\VisitsCollection;
use App\Models\{Comment, File, ScheduledMessage, Visit, Patient};

class DoctorVisitService
{
    private $file_service;

    public function __construct(FileService $file_service)
    {
        $this->file_service = $file_service;
    }

    public function getById(Request $request)
    {
        return VisitResource::make(Visit::find($request->get('id')));
    }

    public function getList(Request $request)
    {
        $patient = Patient::find($request->get('patient_id'));
        $visits = $patient->visits()->orderBy('date', 'desc')->paginate($request->get('per_page'));

        return new VisitsCollection($visits);
    }

    public function create(Request $request)
    {
        $patient = Patient::find($request->get('patient_id'));

        $visit = $patient->visits()->create([
            'date' => $request->get('date'),
            'prescription' => $request->get('prescription'),
            'recommendation' => $request->get('recommendation'),
        ]);

        $visit->doctor_comment()->create([
            'content' => $request->input('doctor_comment.content'),
            'type' => Comment::TYPE_VISIT_DOCTOR
        ]);

        $visit->doctor_comment->files()->saveMany(
            File::find(collect($request->input('doctor_comment.files'))->pluck('id'))
        );

        if ($request->get('private_comment')) {
            $visit->doctor_private_comment()->create([
                'content' => $request->get('private_comment'),
                'type' => Comment::TYPE_VISIT_DOCTOR_PRIVATE
            ]);
        }

        if ($request->input('scheduled_message.content')) {

            $visit->scheduled_message()->create([
                'content' => $request->input('scheduled_message.content'),
                'date' => $request->input('scheduled_message.date'),
            ]);
        }

        $visit->tags()->sync($request->get('tag_ids'));

        return VisitResource::make($visit);
    }

    public function update(Request $request)
    {
        $visit = Visit::find($request->get('id'));

        $visit->update([
            'date' => $request->get('date'),
            'prescription' => $request->get('prescription'),
            'recommendation' => $request->get('recommendation'),
        ]);

        $visit->doctor_comment()->updateOrCreate([
            'type' => Comment::TYPE_VISIT_DOCTOR
        ],[
            'content' => $request->input('doctor_comment.content'),
        ]);

        $visit->doctor_comment->files()->detach();
        $visit->doctor_comment->files()->saveMany(
            File::find(collect($request->input('doctor_comment.files'))->pluck('id'))
        );

        if ($request->get('private_comment')) {
            $visit->doctor_private_comment()->updateOrCreate([
                'type' => Comment::TYPE_VISIT_DOCTOR_PRIVATE
            ], [
                'content' => $request->get('private_comment'),
            ]);
        }

        $visit->scheduled_message()->delete();
        if ($request->input('scheduled_message.content')) {

            $visit->scheduled_message()->create([
                'content' => $request->input('scheduled_message.content'),
                'date' => $request->input('scheduled_message.date'),
            ]);
        }

        $visit->tags()->sync($request->get('tag_ids'));

        return VisitResource::make($visit);
    }

    public function privateComment(Request $request)
    {
        $visit = Visit::find($request->get('id'));
        $comment = $request->get('comment', null);

        if (!$comment) {
            $visit->doctor_private_comment()->delete();
        } else {
            $visit->doctor_private_comment()->updateOrCreate([
                'type' => Comment::TYPE_VISIT_DOCTOR_PRIVATE
            ], [
                'content' => $request->get('comment'),
            ]);
        }

        return VisitResource::make($visit);
    }

    public function delete(Request $request)
    {
        Visit::find($request->get('id'))->delete();
    }
}
