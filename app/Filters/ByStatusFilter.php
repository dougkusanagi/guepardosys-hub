<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ByStatusFilter
{
    public function __construct(
        private Request $request
    ) {}

    public function handle(Builder $builder, Closure $next): Builder
    {
        return $next($builder)
            ->when(
                $this->request->status != null,
                fn($query) => $query->where('status', $this->request->status)
            );
    }
}
