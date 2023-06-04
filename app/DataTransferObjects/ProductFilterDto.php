<?php

namespace App\DataTransferObjects;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;

readonly class ProductFilterDto extends BaseDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $category = null,
        public ?ProductStatusEnum $status = null,
        public ?string $orderBy = null,
        public ?string $direction = null,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return new ProductFilterDto(
            $request->query('name'),
            $request->query('category'),
            ProductStatusEnum::from($request->query('status')),
            $request->query('order_by'),
            $request->query('direction', 'asc'),
        );
    }
}
