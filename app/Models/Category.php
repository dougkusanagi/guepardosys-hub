<?php

namespace App\Models;

use App\DataTransferObjects\CategoryFilterDto;
use App\Filters\Filterable;
use App\Filters\NameFilter;
use App\Filters\OrderByFilter;
use App\Traits\Relationship\BelongsToCompany;
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFilter(Builder $query)
    {
        $filterable = Pipeline::send(new Filterable(
            $query,
            CategoryFilterDto::fromRequest(request())
        ))
            ->through([
                NameFilter::class,
                OrderByFilter::class,
            ])
            ->thenReturn();

        return $filterable->builder;
    }

    public function scopePaginated(Builder $query): LengthAwarePaginator
    {
        return $query->whereBelongsTo(auth()->user()->company)
            ->filter()
            ->paginate(request('per_page', Product::perPage))
            ->withQueryString();
    }
}
