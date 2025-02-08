<?php

namespace App\Traits;

trait WithLoading
{
    public bool $loading = false;

    public function startLoading(): void
    {
        $this->loading = true;
    }

    public function stopLoading(): void
    {
        $this->loading = false;
    }

    public function loading(callable $callback): mixed
    {
        try {
            $this->startLoading();
            return $callback();
        } finally {
            $this->stopLoading();
        }
    }
}
