<?php


use App\Models\Category;
use App\Models\Community;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
        DB::table('users')->insert(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123123123'),
                'dob' => Carbon::now(),
                'number' => '123123123',
                'role' => '"admin"',
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('123123123'),
                'dob' => Carbon::now(),
                'number' => '123123123',
                'role' => '"manager"',
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]
        );
        factory(User::class, 10)->create();
        factory(Category::class, 10)->create();
        factory(Tag::class, 10)->create();
        factory(Forum::class, 10)->create();
        factory(Thread::class, 10)->create();
        factory(Community::class, 10)->create();
        factory(Post::class, 10)->create();
        factory(Comment::class, 10)->create();
    }
}
