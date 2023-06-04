<?php

namespace App\Filters;

use Closure;

class StatusFilter
{
    public function __invoke(Filterable $filterable, Closure $next): Filterable
    {
        $query = $filterable->builder
            ->when(
                $filterable->dto?->status,
                fn ($query) => $query->where('status', $filterable->dto->status)
            );

        return $next(new Filterable($query, $filterable->dto));
    }
}
