<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'offer'           =>   $faker->text($maxNbChars = 75),
        'descreption'     =>   $faker->text($maxNbChars = 200),
        'offerPrecentage' =>   $faker->numberBetween($min = 10, $max = 80),
        'oldPrice'        =>   $faker->numberBetween($min = 0, $max = 100000),
        'startDate'       =>   $faker->dateTimeBetween('-5 days','+30 days'),
        'endDate'         =>   $faker->dateTimeBetween('+10 days','+60 days'),
        'rating'          =>   $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 5),
        'views'           =>   $faker->numberBetween($min = 0, $max = 10000),
        'url'             =>   $faker->url,
        'isOnline'        =>   $faker->boolean,
        'copon'           =>   $faker->unique()->ean8(),
        'allBranches'     =>   $faker->boolean,
        'proirity'        =>   $faker->boolean,

        'category_id'=> \App\Category::all()->random()->id,
        'user_id'=> \App\User::all()->random()->id

    ];
});

