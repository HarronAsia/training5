<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Forum;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Forum::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'category_id'=>rand(1,10),
        'user_id'=>rand(1,10),
    ];
});
