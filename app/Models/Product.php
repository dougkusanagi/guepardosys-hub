<?php

namespace App\Models;

use App\DataTransferObjects\ProductFilterDto;
use App\Filters\CategoryFilter;
use App\Filters\Filterable;
use App\Filters\NameFilter;
use App\Filters\OrderByFilter;
use App\Filters\StatusFilter;
use App\Traits\Relationship\BelongsToCategory;
use App\Traits\Relationship\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, BelongsToCategory, BelongsToCompany;

    public const perPage = "25";
    protected $guarded = [];
    protected $appends = ['images'];

    public function scopeFilter(Builder $query)
    {
        $filterable = Pipeline::send(new Filterable(
            $query,
            ProductFilterDto::fromRequest(request())
        ))
            ->through([
                NameFilter::class,
                CategoryFilter::class,
                StatusFilter::class,
                OrderByFilter::class,
            ])
            ->thenReturn();

        return $filterable->builder;
    }

    public function scopePaginated(Builder $query): LengthAwarePaginator
    {
        return $query->whereBelongsTo(auth()->user()->company)
            ->with(['category'])
            ->filter()
            ->paginate(request('per_page', Product::perPage))
            ->withQueryString();
    }

    public function getImagesAttribute()
    {
        return !$this->getMedia('images')->isEmpty()
            ? $this->getMedia('images')
            : [
                ['original_url' => '/img/no-image.png']
            ];
    }
}
