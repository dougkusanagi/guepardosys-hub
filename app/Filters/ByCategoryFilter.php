<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ByCategoryFilter
{
    public function __construct(
        private Request $request
    ) {}

    public function handle(Builder $builder, Closure $next): Builder
    {
        return $next($builder)
            ->when(
                $this->request->category,
                fn($query) => $query->where('category_id', $this->request->category)
            );
    }
}
