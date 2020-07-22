<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;


$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment_detail' => $faker->paragraph,
        'commentable_type'=> 'App\Post',
        'commentable_id'=> rand(1,10),
        'user_id'=> rand(1,10),
    ];
});
