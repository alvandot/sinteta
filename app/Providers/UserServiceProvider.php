<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Implementations\UserService;
use App\Models\User;
use App\Models\Users\Tentor;
use App\Models\Users\Siswa;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind('user.service', function ($app) {
            return new UserService(
                new User(),
                new Tentor(),
                new Siswa()
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
