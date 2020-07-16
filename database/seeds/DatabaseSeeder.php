<?php

use App\Category;
use App\Forum;
use App\Tag;
use App\Thread;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        
        // factory(User::class,100)->create();
        // factory(Category::class,100)->create();
        // factory(Tag::class,100)->create();
        // factory(Forum::class,100)->create();
        factory(Thread::class,100)->create();
    }
}
