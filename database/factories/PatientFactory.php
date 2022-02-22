<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Patient::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => str_replace('+', '', $faker->unique()->e164PhoneNumber),
        'birthday' => $faker->dateTime(),
        'registered_at' => $faker->dateTimeBetween('-10 years'),
        'last_login_at' => $faker->dateTimeBetween('-10 years')
    ];
});

$factory->afterCreating(\App\Models\Patient::class, function ($patient, $faker) {
    $patient->cities()->sync(\App\Models\City::all()->random(3)->pluck('id'));
});
