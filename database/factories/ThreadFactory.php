<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Thread;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,100),
        'tag_id' =>rand(1,100),
        'forum_id' => rand(1,100),
        'title' => $faker->title,
        'detail' => $faker->paragraph,
        'status' => 'public',
    ];
});
