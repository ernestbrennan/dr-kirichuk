<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\ScheduledMessage\ScheduledMessageCollection;
use App\Http\Resources\ScheduledMessage\ScheduledMessageResource;
use App\Models\City;
use App\Models\Patient;
use App\Models\ScheduledMessage;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ScheduledMessageService
{
    public function getList(Request $request)
    {
        $patient = Patient::find($request->input('patient_id'));

        $scheduled_messages = ScheduledMessage::query()->where(function (Builder $query) use ($patient) {
            $query->where('messageable_type', $patient->getMorphClass())
                ->where('messageable_id', $patient->id);
        })->orWhere(function (Builder $query) use ($patient) {
            $query->where('messageable_type', 'visit')
                ->whereIn('messageable_id', $patient->visits->pluck('id'));
        })
            ->paginate($request->get('per_page'));

        return new ScheduledMessageCollection($scheduled_messages);
    }

    public function create(Request $request)
    {
        $patient = Patient::find($request->input('patient_id'));

        $scheduled_message = $patient->scheduled_messages()->create([
            'content' => $request->get('content'),
            'date' => $request->get('date'),
        ]);

        return ScheduledMessageResource::make($scheduled_message);
    }

    public function update(Request $request)
    {
        $scheduled_message = ScheduledMessage::find($request->get('id'));

        $scheduled_message->update([
            'content' => $request->get('content'),
            'date' => $request->get('date'),
        ]);

        return ScheduledMessageResource::make($scheduled_message);
    }

    public function delete(Request $request)
    {
        ScheduledMessage::find($request->get('id'))->delete();
    }
}
