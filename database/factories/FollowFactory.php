<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Follow;
use Faker\Generator as Faker;

$factory->define(Follow::class, function (Faker $faker) {
    return [

        'user_id' =>  \App\User::all()->random()->id,
        'branch_id'=> \App\Branch::all()->random()->id

    ];
});
