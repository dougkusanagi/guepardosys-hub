<?php

namespace App\Filters;

use Closure;

class NameFilter
{
    public function __invoke(Filterable $filterable, Closure $next): Filterable
    {
        $query = $filterable->builder
            ->when(
                $filterable->dto?->name,
                fn ($query) => $query->where('name', 'LIKE', "%{$filterable->dto->name}%")
            );

        return $next(new Filterable($query, $filterable->dto));
    }
}
