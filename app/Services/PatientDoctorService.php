<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\Patient\Doctor\PatientResource;
use App\Http\Resources\Patient\Doctor\PatientsCollection;
use App\Models\Comment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PatientDoctorService
{
    private $auth_service;
    private $file_service;

    public function __construct(PatientAuthService $auth_service, FileService $file_service)
    {
        $this->auth_service = $auth_service;
        $this->file_service = $file_service;
    }

    public function getList(Request $request)
    {
        $search = collect($request->get('search'));
        $cities_id = $request->get('cities_id');
        $age = $request->get('age', null) ? collect($request->get('age', null)) : null;
        $sort_by = $request->get('sort_by', null);

        $query = Patient::query()->select('*')
            ->when($search->get('default'), function (Builder $query) use ($search) {
                return $query->where(function (Builder $query) use ($search) {
                    $query->where('phone', 'like', "%" . $search->get('default') . "%")
                        ->orWhere('first_name', 'like', "%" . $search->get('default') . "%")
                        ->orWhere('last_name', 'like', "%" . $search->get('default') . "%");
                })
                    ->orWhereHas('visits.doctor_private_comment', function (Builder $query) use ($search) {
                        $query->where('content', 'like', "%" . $search->get('default') . "%");
                    });
            })
            ->when($search->get('prescription'), function (Builder $query) use ($search) {
                return $query->whereHas('visits', function (Builder $query) use ($search) {
                    $query->where('prescription', 'like', "%" . $search->get('prescription') . "%");
                });
            })
            ->when($search->get('comment'), function (Builder $query) use ($search) {
                return $query->whereHas('visits.doctor_comment', function (Builder $query) use ($search) {
                    $query->where('content', 'like', "%" . $search->get('comment') . "%");
                });
            })
            ->when($search->get('doctor_private_comment'), function (Builder $query) use ($search) {
                return $query->whereHas('visits.doctor_private_comment', function (Builder $query) use ($search) {
                    $query->where('content', 'like', "%" . $search->get('doctor_private_comment') . "%");
                });
            })
            ->when($cities_id, function (Builder $query) use ($cities_id) {
                return $query->whereHas('cities', function ($query) use ($cities_id) {
                    return $query->whereIn('id', $cities_id);
                });
            })
            ->when($age, function (Builder $query) use ($age) {
                $query->where(DB::raw('TIMESTAMPDIFF(YEAR, patients.birthday, CURDATE())'), '>=', $age->get('from'))
                    ->where(DB::raw('TIMESTAMPDIFF(YEAR, patients.birthday, CURDATE())'), '<=', $age->get('to'));
            })
            ->when($sort_by, function (Builder $query) use ($sort_by) {
                switch ($sort_by) {
                    case 'by_last_visit':
                        $query->selectRaw(DB::raw('(SELECT max(date) FROM visits WHERE patient_id = patients.id ) as last_visit_order'))->orderBy('last_visit_order', 'desc');

                        break;
                    case 'by_registered_at':
                        $query->orderBy('registered_at', 'desc');
                        break;
                    case 'by_name':
                        $query->orderBy('last_name', 'asc');
                        break;
                    case 'by_age':
                        $query->orderBy('birthday', 'desc');
                        break;
                }

                return $query;
//            });dd($patients->toSql());
            });

//        $builder = str_replace(array('?'), array('\'%s\''), $query->toSql());
//        $builder = vsprintf($builder, $query->getBindings());
//        dd($builder);

        return new PatientsCollection($query->paginate($request->get('per_page')));
    }

    public function getById(Request $request)
    {
        return PatientResource::make(Patient::find($request->get('id')));
    }

    public function addComment(Request $request)
    {
        $patient = Patient::find($request->get('id'));

        $comment = $request->get('comment', null);

        if (!$comment) {
            $patient->doctor_comment()->delete();
        } else {
            $patient->doctor_comment()->updateOrCreate([
                'type' => Comment::TYPE_PATIENT_DOCTOR
            ], [
                'content' => $request->get('comment'),
            ]);
        }
    }
}
