<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Thread;


use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;


$factory->define(Thread::class, function (Faker $faker) {

    // $filepath = storage_path('app/public/thread/'.$faker->title.'/');
    //     if(!File::exists( $filepath)){ 
    //         File::makeDirectory( $filepath);
    //     }
    //     else
    //     {
    //         unlink($filepath);
    //         File::makeDirectory( $filepath);
    //     }
    
    return [

        'user_id' => rand(1,10),
        'tag_id' =>rand(1,10),
        'forum_id' => rand(1,10),
        'title' => $faker->title,
        'detail' => $faker->paragraph,
        'status' => 'public',
        
        // 'thumbnail' => $faker->image($filepath,640,480,null,false),
    ];
});
