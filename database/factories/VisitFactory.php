<?php

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(\App\Models\Visit::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime(),
        'prescription' => $faker->text,
        'recommendation' => $faker->text,
        'created_at' => $faker->dateTimeBetween('-10 years')
    ];
});
