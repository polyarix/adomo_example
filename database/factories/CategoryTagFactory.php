<?php

use App\Entity\Advert\Tag;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'slug' => $faker->unique()->text,
    ];
});
