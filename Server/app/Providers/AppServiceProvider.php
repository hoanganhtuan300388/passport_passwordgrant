<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // bootstrap custom validation
        Validator::extend('friend_exists', 'App\Validators\CustomValidator@checkFriendExists');
        Validator::extend('member_exists', 'App\Validators\CustomValidator@checkMemberExists');
        Validator::extend('member_creator', 'App\Validators\CustomValidator@checkMemberCreator');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}
