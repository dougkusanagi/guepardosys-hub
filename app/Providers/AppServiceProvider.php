<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(
            app()->isLocal()
        );
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Helpers/**/*.php') as $filename) {
            require_once $filename;
        }
    }
}
