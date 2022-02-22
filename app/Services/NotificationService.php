<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\Notification\NotificationCollection;
use App\Models\City;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function getList(Request $request)
    {
//        $notifications = Notification::where('is_read', false)
//            ->orderBy('id', 'desc')
//            ->paginate($request->get('per_page', 15));

        $notifications = Notification::where('created_at','>=', \Carbon\Carbon::today()->subDays(7))
            ->orderBy('id', 'desc')
            ->paginate($request->get('per_page', 15));

        return new NotificationCollection($notifications);
    }

    public function read(Request $request)
    {
        Notification::find($request->get('id'))->update([
            'is_read' => true
        ]);
    }
}
