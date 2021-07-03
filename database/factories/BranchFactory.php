<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {


    $openAt = $faker->time($format = 'H:i:s');
    $closeAt = $faker->time($format = 'H:i:s');


    return [
        'name'           =>   $faker->company,
        'latitude'       =>   $faker->randomFloat,
        'longitude'      =>   $faker->randomFloat,

        'country'        =>   $faker->country,
        'city'           =>   $faker->city,
        'street'         =>   $faker->streetName,

        'view'           =>   $faker->numberBetween($min = 0, $max = 1000),
        'openAt_closeAt' =>   $openAt . " , " . $closeAt,
        'description'    =>   $faker->text($maxNbChars = 200),
        'phoneNumber'    =>   $faker->phoneNumber,
        'url'            =>   $faker->url,

        'company_id'     =>   \App\Company::all()->random()->id,
        'user_id'        =>   \App\User::all()->random()->id

    ];
});
