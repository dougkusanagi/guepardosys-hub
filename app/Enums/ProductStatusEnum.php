<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum ProductStatusEnum: int
{
    case Inactive = 0;
    case Active = 1;
    case Waiting = 2;

    public static function asSelectArray(): Collection
    {
        return collect(self::cases())
            ->map(fn ($status, $index) => ['id' => $index, 'name' => $status]);
    }

    public static function asArray(): array
    {
        return self::cases();
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function arrayFliped(): array
    {
        return array_combine(self::values(), self::names());
    }
}
