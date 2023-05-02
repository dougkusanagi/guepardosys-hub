<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProductStatusEnum extends Enum
{
    const Inactive = 0;
    const Active = 1;
    const Waiting = 2;
}
