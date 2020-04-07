<?php

use App\Entity\User\Company\Company;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'slug' => $faker->unique()->slug,
        'description' => $faker->realText(),
        'workers_count' => random_int(2, 30)
    ];
});
