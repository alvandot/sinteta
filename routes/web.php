<?php

declare(strict_types=1);

use Illuminate\Support\Facades\{Auth, Route};

require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/siswa.php';
require __DIR__ . '/web/kacap.php';
require __DIR__ . '/web/tentor.php';
require __DIR__ . '/web/auth.php';

Route::get('/', function (): \Illuminate\Http\RedirectResponse {
    if (Auth::check()) {
        $roles = [
            'siswa' => 'siswa.dashboard',
            'kacap' => 'kacap.dashboard',
            'tentor' => 'tentor.dashboard',
            'admin' => 'admin.dashboard'
        ];

        foreach ($roles as $role => $route) {
            if (Auth::user()->hasRole($role)) {
                return redirect()->route($route);
            }
        }
    }

    return redirect('/siswa/login');
})->name('root');



