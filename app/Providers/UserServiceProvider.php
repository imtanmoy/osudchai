<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('user.verification', function () {
            return new App\Services\UserService\UserVerification;
        });
    }
}
