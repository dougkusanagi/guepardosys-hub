<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ByNameFilter
{
    public function __construct(
        private Request $request
    ) {}

    public function handle(Builder $builder, Closure $next): Builder
    {
        return $next($builder)
            ->when(
                $this->request->name,
                fn($query) => $query->where('name', 'REGEXP', $this->request->name)
            );
    }
}
