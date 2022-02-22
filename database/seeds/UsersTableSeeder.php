<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Doctor::create([
            'name' => 'doctor',
            'api_token' => env('DOCTOR_API_TOKEN', hash('sha256', Str::random(60)))
        ]);

        // factory(\App\Models\Patient::class, 1000)->create();
    }
}
