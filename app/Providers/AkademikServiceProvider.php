<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AkademikServiceInterface;
use App\Services\Implementations\AkademikService;
use App\Models\Akademik\Ujian;
use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\JadwalBelajar;

class AkademikServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AkademikServiceInterface::class, AkademikService::class);

        $this->app->bind('akademik.service', function ($app) {
            return new AkademikService(
                new Ujian(),
                new MataPelajaran(),
                new KelasBimbel(),
                new JadwalBelajar()
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
