<?php

use App\Entity\User\Company\Article;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'content' => $faker->realText(),
        'slug' => $faker->unique()->slug,
    ];
});
