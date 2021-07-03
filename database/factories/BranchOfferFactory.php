<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BranchOffer;
use Faker\Generator as Faker;

$factory->define(BranchOffer::class, function () {
    return [
        'offer_id' => \App\Offer::all()->random()->id,
        'branch_id' => \App\Branch::all()->random()->id
    ];
});
