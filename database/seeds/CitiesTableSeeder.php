<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {

        DB::unprepared(file_get_contents(storage_path('files/cities_archive.sql')));

        $cities = [
            'Киев',
            'Донецк',
            'Харьков',
            'Краматорск',
            'Мариуполь',
            'Одесса',
            'Бремен',
            'Антверпен',
            'Барселона',
            'Москва',
            'Ялта'
        ];

        foreach ($cities as $city) {
            \App\Models\City::create(['name' => $city]);
        }
    }
}
