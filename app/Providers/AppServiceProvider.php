<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        Gate::define('admin', function (User $user){
            return $user->roles === 'admin';
        });

        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });

        Gate::define('manager', function (User $user){
            return $user->roles === 'manager';
        });

        Blade::if('manager', function () {
            return request()->user()?->can('manager');
        });


    }
}
