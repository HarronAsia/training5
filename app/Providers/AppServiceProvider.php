<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class,

        );
        $this->app->singleton(
            \App\Repositories\Thread\ThreadRepositoryInterface::class,
            \App\Repositories\Thread\ThreadRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Admin\AdminRepositoryInterface::class,
            \App\Repositories\Admin\AdminRepository::class

        );

        $this->app->singleton(
            \App\Repositories\User\Account\ProfileRepositoryInterface::class,
            \App\Repositories\User\Account\ProfileRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Thread\Tag\TagRepositoryInterface::class,
            \App\Repositories\Thread\Tag\TagRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Category\CategoryRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Forum\ForumRepositoryInterface::class,
            \App\Repositories\Forum\ForumRepository::class

        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
