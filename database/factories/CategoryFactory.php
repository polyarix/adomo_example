<?php

use App\Entity\Advert\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'slug' => $faker->unique()->slug,
        'breadcrumb_name' => $faker->text,
        'meta_title' => $faker->realText(),
        'meta_description' => $faker->realText(),
        'meta_keywords' => $faker->realText(),
        'seo_text' => $faker->realText(),
    ];
});
