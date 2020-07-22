<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('updatethread', function ($user, $thread) {
            return $user->id == $thread->user_id;
        });

        Gate::define('deletethread', function ($user, $thread) {
            return $user->id == $thread->user_id;
        });

        Gate::define('updateforum', function ($user, $forum) {
            return $user->id == $forum->user_id;
        });

        Gate::define('deleteforum', function ($user, $forum) {
            return $user->id == $forum->user_id;
        });
    }
}
