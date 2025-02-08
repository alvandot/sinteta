<?php

namespace App\Traits;

trait WithNotification
{
    public function success(string $message, string $title = 'Berhasil!'): void
    {
        $this->notification()->success(
            title: $title,
            description: $message,
        );
    }

    public function error(string $message, string $title = 'Gagal!'): void
    {
        $this->notification()->error(
            title: $title,
            description: $message,
        );
    }

    public function warning(string $message, string $title = 'Perhatian!'): void
    {
        $this->notification()->warning(
            title: $title,
            description: $message,
        );
    }

    public function info(string $message, string $title = 'Informasi'): void
    {
        $this->notification()->info(
            title: $title,
            description: $message,
        );
    }
}
