<?php

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ComentsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Visit::all()->each(function ($visit) {

            $faker = app(Faker::class);

            $visit->doctor_comment()->create([
                'content' => $faker->text,
                'type' => Comment::TYPE_VISIT_DOCTOR
            ]);

            $visit->doctor_private_comment()->create([
                'content' => $faker->text,
                'type' => Comment::TYPE_VISIT_DOCTOR_PRIVATE
            ]);

            $visit->patient_private_comment()->create([
                'content' => $faker->text,
                'type' => Comment::TYPE_VISIT_PATIENT_PRIVATE
            ]);
        });;
    }
}
