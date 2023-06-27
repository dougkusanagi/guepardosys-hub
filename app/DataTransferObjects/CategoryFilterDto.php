<?php

namespace App\DataTransferObjects;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;

class CategoryFilterDto implements BaseDto
{
    public function __construct(
        readonly public ?string $name = null,
        readonly public ?string $orderBy = null,
        readonly public ?string $direction = null,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return new self(
            $request->query('name'),
            $request->query('order_by', 'name'),
            $request->query('direction', 'asc'),
        );
    }
}
