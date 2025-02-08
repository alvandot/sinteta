<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\{
    AuthServiceInterface,
    UserServiceInterface,
    UjianServiceInterface,
    SiswaServiceInterface,
    TentorServiceInterface,
    AkademikServiceInterface
};
use App\Services\Implementations\{
    AuthService,
    UserService,
    UjianService,
    SiswaService,
    TentorService,
    AkademikService
};
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public array $singletons = [
        AuthServiceInterface::class => AuthService::class,
        UserServiceInterface::class => UserService::class,
        UjianServiceInterface::class => UjianService::class,
        SiswaServiceInterface::class => SiswaService::class,
        TentorServiceInterface::class => TentorService::class,
        AkademikServiceInterface::class => AkademikService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Mary\MaryServiceProvider::class);
        $this->app->register(\Livewire\LivewireServiceProvider::class);
        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);

        // Register services as singletons
        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->app->bind(UjianServiceInterface::class, UjianService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::componentNamespace('App\\View\\Components\\Soal', 'soal');
    }
}
