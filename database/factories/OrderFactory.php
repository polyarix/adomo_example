<?php

use App\Entity\Advert\Advert\Order;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Order::class, function (Faker $faker) {
    $status = Arr::random(array_keys(Order::getStatusList()));

    return [
        'title' => $faker->jobTitle,
        'description' => $faker->realText(),
        'slug' => $faker->unique()->slug,
        'price' => $faker->numberBetween(),
        'price_type' => Arr::random([Order::PRICE_TYPE_SPECIFIC, Order::PRICE_TYPE_MIN, Order::PRICE_TYPE_MAX]),
        'address' => $faker->address,
        'beginning_date' => $faker->date,
        'map_address' => $faker->streetAddress,
        'map_lat' => $faker->latitude,
        'map_long' => $faker->longitude,
        'house_provision' => $faker->boolean,
        'materials_provision' => $faker->boolean,
        'status' => $status,
        'close_reason' => in_array($status, [Order::STATUS_CLOSED, Order::STATUS_REJECTED]) ? $faker->realText() : null,
        'closed_at' => in_array($status, [Order::STATUS_CLOSED, Order::STATUS_REJECTED]) ? $faker->dateTime : null,
        'moderated_at' => $status === Order::STATUS_ACTIVE ? $faker->dateTime : null,
        'meta_title' => $faker->jobTitle,
        'meta_description' => $faker->text,
        'meta_keywords' => $faker->words(5, true),
    ];
});
