<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

trait FilterTraitScope
{
    public function scopeFilter(Builder $builder)
    {
        return Pipeline::send($builder)
            ->through($this->scopeFilters)
            ->thenReturn();
    }
}
