<?php

use App\Entity\User\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'sex' => rand(0, 1),
        'type' => $faker->randomElement(array_keys(User::getTypes())),
        'role' => $faker->randomElement(array_keys(User::getRoles())),
    ];
});
