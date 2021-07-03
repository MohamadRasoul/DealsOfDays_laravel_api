<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Copon;
use Faker\Generator as Faker;

$factory->define(Copon::class, function (Faker $faker) {
    return [
        'copon'=>$faker->ean8,
        'active'=>$faker->boolean,
        'user_id'=>\App\User::all()->random()->id,
        'offer_id'=>\App\Offer::all()->random()->id,
    ];
});

