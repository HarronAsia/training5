<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;

use Faker\Generator as Faker;

$factory->define(Community::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
    ];
});
