<?php

namespace App\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

trait ScopeFilterTrait
{
    public function scopeFilter(Builder $builder)
    {
        return Pipeline::send($builder)
            ->through($this->scopeFilters)
            ->thenReturn();
    }
}
