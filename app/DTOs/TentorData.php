<?php

declare(strict_types=1);

namespace App\DTOs;

class TentorData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $mataPelajaran,
        public readonly string $pendidikanTerakhir,
        public readonly string $jurusan,
        public readonly string $spesialisasi
    ) {}
}
