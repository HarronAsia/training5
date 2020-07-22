<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'detail' => $faker->paragraph,
        'user_id' => rand(1,10),
        'community_id' => rand(1,10),
    ];
});
