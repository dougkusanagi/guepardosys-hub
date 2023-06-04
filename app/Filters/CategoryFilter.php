<?php

namespace App\Filters;

use Closure;

class CategoryFilter
{
    public function __invoke(Filterable $filterable, Closure $next): Filterable
    {
        $query = $filterable->builder
            ->when(
                $filterable->dto?->category,
                fn ($query) => $query->where('category_id', $filterable->dto->category)
            );

        return $next(new Filterable($query, $filterable->dto));
    }
}
