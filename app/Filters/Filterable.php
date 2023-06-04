<?php

namespace App\Filters;

use App\DataTransferObjects\BaseDto;
use Illuminate\Database\Eloquent\Builder;

class Filterable
{
    public function __construct(
        public Builder $builder,
        public BaseDto $dto
    ) {
    }
}
