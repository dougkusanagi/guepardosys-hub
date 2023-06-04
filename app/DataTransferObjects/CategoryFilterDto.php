<?php

namespace App\DataTransferObjects;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;

readonly class CategoryFilterDto implements BaseDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $orderBy = null,
        public ?string $direction = null,
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
