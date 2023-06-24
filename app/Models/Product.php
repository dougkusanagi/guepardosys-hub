<?php

namespace App\Models;

use App\Filters\ByCategoryFilter;
use App\Filters\ByNameFilter;
use App\Filters\ByStatusFilter;
use App\Filters\OrderByFilter;
use App\Traits\Relationships\BelongsToCategory;
use App\Traits\Relationships\BelongsToCompany;
use App\Traits\Scope\ScopeFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, BelongsToCategory, BelongsToCompany, ScopeFilterTrait;

    public const perPage = "25";
    protected $guarded = [];
    protected $appends = ['images'];
    protected $scopeFilters = [
        ByNameFilter::class,
        ByCategoryFilter::class,
        ByStatusFilter::class,
        OrderByFilter::class,
    ];

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
            : null;

        // old [['original_url' => '/img/no-image.png']]
    }
}
