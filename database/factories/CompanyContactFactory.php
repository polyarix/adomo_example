<?php

use App\Entity\User\Company\Contact;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Contact::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'contacts' => "{$faker->phoneNumber} {$faker->email}",
        'schedule' => $faker->text,
    ];
});
