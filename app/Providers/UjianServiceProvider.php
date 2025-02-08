<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\UjianServiceInterface;
use App\Services\Implementations\UjianService;
use App\Models\UjianSiswa;
use App\Models\Jawaban;
use App\Models\HasilUjian;
use App\Models\DaftarUjianSiswa;
use App\Models\Soal\Soal;
use App\Models\Soal\PaketSoal;

class UjianServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UjianServiceInterface::class, UjianService::class);

        $this->app->bind('ujian.service', function ($app) {
            return new UjianService(
                new UjianSiswa(),
                new Jawaban(),
                new HasilUjian(),
                new DaftarUjianSiswa(),
                new Soal(),
                new PaketSoal()
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
