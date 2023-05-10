<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public const perPage = "25";

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(request('order_by'), fn ($query, $field) => $query->orderBy($field, request('direction')))
            ->when(request('search'), fn ($query) => $query->search());
    }
}
