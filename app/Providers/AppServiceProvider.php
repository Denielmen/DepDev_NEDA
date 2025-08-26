<?php

namespace App\Providers;

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
        // Register the AdminHelper as a global view variable
        view()->composer('*', function ($view) {
            $view->with('isReadOnlyAdmin', \App\Helpers\AdminHelper::isReadOnlyAdmin());
        });
    }
}
