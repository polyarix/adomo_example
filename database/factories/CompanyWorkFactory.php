<?php

use App\Entity\User\Company\Portfolio\Work;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Work::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->realText(),
        'price' => random_int(100, 2255),
        'duration' => random_int(1, 22),
        'duration_type' => array_random(array_keys(Work::getDurationTypes())),
    ];
});
