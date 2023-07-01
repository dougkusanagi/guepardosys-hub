<?php

namespace App\Models;

use App\Filters\ByCategoryFilter;
use App\Filters\ByNameFilter;
use App\Filters\ByStatusFilter;
use App\Filters\OrderByFilter;
use App\Traits\Relationships\BelongsToCategory;
use App\Scopes\FilterTraitScope;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, BelongsToCategory, Tenantable, FilterTraitScope;

    public const perPage = "25";

    protected $guarded = ['id'];

    protected $appends = ['images'];

    protected $scopeFilters = [
        ByNameFilter::class,
        ByCategoryFilter::class,
        ByStatusFilter::class,
        OrderByFilter::class,
    ];

    public function scopePaginated(Builder $query): LengthAwarePaginator
    {
        return $query
            ->with(['category'])
            ->filter()
            ->paginate(request('per_page', Product::perPage))
            ->withQueryString();
    }

    public function getImagesAttribute()
    {
        return !$this->getMedia('images')->isEmpty()
            ? $this->getMedia('images')->map(function (Media $media) {
                return $media->getUrl();
            })
            : null;
    }
}
