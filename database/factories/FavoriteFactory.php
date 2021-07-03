<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        
        'user_id' =>  \App\User::all()->random()->id,
        'offer_id' =>  \App\Offer::all()->random()->id,

    ];
});
