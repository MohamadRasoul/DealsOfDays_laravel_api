<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name'=>$faker->company,
        "image" => $faker->imageUrl(200, 200,'abstract', true, 'Faker', true),
        "cover" => $faker->imageUrl(600, 200,'abstract', true, 'Faker', true),

        'user_id' =>\App\User::all()->random()->id
    ];
});



// $table->string('name');
// $table->string('image');
// $table->string('mainLocation');

// $table->foreignId('user_id');
