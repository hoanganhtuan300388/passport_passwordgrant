<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\MemberRepository::class, \App\Repositories\MemberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MemberContactRepository::class, \App\Repositories\MemberContactRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MemberSettingRepository::class, \App\Repositories\MemberSettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroupRepository::class, \App\Repositories\GroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactRepository::class, \App\Repositories\ContactRepositoryEloquent::class);
    }

}