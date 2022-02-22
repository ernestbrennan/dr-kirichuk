<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class VisitsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Patient::all()->each(function ($patient) {
            $patient->visits()->createMany(factory(\App\Models\Visit::class, 10)->make()->toArray());
        });;
    }
}
