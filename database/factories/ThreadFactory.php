<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Thread;


use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

$factory->define(Thread::class, function (Faker $faker) {


    return [

        'user_id' => rand(1,10),
        'tag_id' =>rand(1,10),
        'forum_id' => rand(1,10),
        'title' => $faker->title,
        'detail' => $faker->paragraph,
        'status' => 'public',
        
        //'thumbnail' => $faker->image(Storage::makeDirectory(public_path()."thread/.$faker->title",0777),640,480,null,false),
    ];
});
