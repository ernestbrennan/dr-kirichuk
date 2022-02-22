<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityResource;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityService
{
    public function getList(Request $request)
    {
        $cities = City::query()->when($request->get('search'), function ($query) use ($request) {
            $query->where('name', 'like', "%" . $request->get('search') . "%");
        })
            ->get();

        return new CityCollection($cities);
    }

    public function getArhiveList(Request $request)
    {
        $cities = DB::table('cities_archive')
            ->when($request->get('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%" . $request->get('search') . "%");
            })
            ->get();

        return new CityCollection($cities);
    }

    public function create(Request $request)
    {
        $cities_archive = DB::table('cities_archive')->find($request->get('city_archive_id'));
        $city = City::firstOrCreate(['name' => $cities_archive->name]);

        return CityResource::make($city);
    }
}
