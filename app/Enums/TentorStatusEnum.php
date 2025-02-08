<?php

declare(strict_types=1);

namespace App\Enums;

enum TentorStatusEnum: string
{
    case ACTIVE = 'aktif';
    case INACTIVE = 'nonaktif';
}
