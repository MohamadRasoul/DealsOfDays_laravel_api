<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $typeImage =  $faker->randomElement($array = array ('business','fashion', 'nightlife', 'food', 'technics'));
    
    return [
        'offer_image_path' => $faker->imageUrl(640, 480, $typeImage , true, 'Faker'),

        'offer_id' =>  \App\Offer::all()->random()->id,
       
    ];
});
