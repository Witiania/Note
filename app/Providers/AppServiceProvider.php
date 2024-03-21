<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        //
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            $phone_number_validation_regex = "/^\\+?[1-9][0-9]{7,14}$/";
            return preg_match($phone_number_validation_regex, $value) === 1;
        });
    }
}
