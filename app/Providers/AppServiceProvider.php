<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        JsonResource::withoutWrapping();

        View::composer('layouts.dashboard', function ($view) {
            $user = Auth::user();
            $title = 'Store.sy';

            $view->with('username', $user->name);
            $view->with('title', $title);
        });

        // to create a general and a global filter that can be used in all app
        Validator::extend('filter', function ($attribute, $value, $params) {
            return ! in_array(strtolower($value), $params);

        },
            'this value is forbidden!'
        );

        Paginator::useBootstrapFive();
    }
}
