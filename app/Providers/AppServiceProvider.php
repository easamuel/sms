<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Sms\SmsStudent;
use App\Observers\SmsStudentObserver;

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
        // Register model observers
        SmsStudent::observe(SmsStudentObserver::class);

        // Ensure errors ViewErrorBag is always present in views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (!isset($view->getData()['errors'])) {
                $view->with('errors', session('errors', new \Illuminate\Support\ViewErrorBag()));
            }
        });
    }
}
