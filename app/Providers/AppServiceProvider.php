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

        $this->app->singleton(
            \App\Repositories\Community\CommunityRepositoryInterface::class,
            \App\Repositories\Community\CommunityRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Post\PostRepositoryInterface::class,
            \App\Repositories\Post\PostRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Comment\CommentRepositoryInterface::class,
            \App\Repositories\Comment\CommentRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Notification\NotificationRepositoryInterface::class,
            \App\Repositories\Notification\NotificationRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Follower\FollowerRepositoryInterface::class,
            \App\Repositories\Follower\FollowerRepository::class

        );

        $this->app->singleton(
            \App\Repositories\Report\ReportRepositoryInterface::class,
            \App\Repositories\Report\ReportRepository::class

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
