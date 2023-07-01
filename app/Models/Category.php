<?php

namespace App\Models;

use App\Filters\ByNameFilter;
use App\Filters\OrderByFilter;
use App\Scopes\FilterTraitScope;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

class Category extends Model
{
    use HasFactory, Tenantable, FilterTraitScope;

    public const perPage = "25";

    protected $guarded = ['id'];

    protected $scopeFilters = [
        ByNameFilter::class,
        OrderByFilter::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopePaginated(Builder $query): LengthAwarePaginator
    {
        return $query
            ->filter()
            ->paginate(request('per_page', Product::perPage))
            ->withQueryString();
    }
}
