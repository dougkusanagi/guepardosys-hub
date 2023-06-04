<?php

namespace App\Filters;

use Closure;

class OrderByFilter
{
    public function __invoke(Filterable $filterable, Closure $next): Filterable
    {
        $query = $filterable->builder
            ->when(
                $filterable->dto?->orderBy,
                fn ($query) => $query->orderBy($filterable->dto->orderBy, $filterable->dto->direction)
            );

        return $next(new Filterable($query, $filterable->dto));
    }
}
