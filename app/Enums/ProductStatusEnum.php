<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enums\EnumToArray;
use Illuminate\Support\Collection;

enum ProductStatusEnum: int
{
    use EnumToArray;

    case Inactive = 0;
    case Active = 1;
    case Waiting = 2;

    public static function asSelectArray(): Collection
    {
        // dd(self::cases());
        return collect(self::cases())
            ->map(fn ($status) => ['id' => $status->value, 'name' => $status->name]);
    }
}
