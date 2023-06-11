<?php

namespace App\Models;

use App\Filters\ByNameFilter;
use App\Filters\OrderByFilter;
use App\Traits\Relationships\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;

class Category extends Model
{
    use HasFactory;
    use BelongsToCompany;

    public const perPage = "25";
    protected $guarded = [];
    protected $queryFilters = [
        ByNameFilter::class,
        OrderByFilter::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFilter(Builder $builder)
    {
        return Pipeline::send($builder)
            ->through($this->queryFilters)
            ->thenReturn();
    }

    public function scopePaginated(Builder $query): LengthAwarePaginator
    {
        return $query->whereBelongsTo(auth()->user()->company)
            ->filter()
            ->paginate(request('per_page', Product::perPage))
            ->withQueryString();
    }
}
