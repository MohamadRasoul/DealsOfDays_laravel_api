<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'rating'=>$faker->numberBetween($min = 0, $max = 5),        
        'description'=>$faker->text($maxNbChars = 200),        
        'offer_id'=> \App\Offer::all()->random()->id,        
        'user_id'=> \App\User::all()->random()->id        
    ];
});


