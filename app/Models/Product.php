<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const perPage = "25";
    protected $guarded = [];
    protected $with = ['productModel'];
    protected $appends = ['images'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function productModel(): HasOne
    {
        return $this->hasOne(ProductModel::class);
    }

    public function scopeStatus(Builder $query): Builder
    {
        return $query->where('status', request('status'));
    }

    public function scopeSearch(Builder $query): Builder
    {
        return $query->where('name', 'like', request('search') . '%');
    }

    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(request('category'), fn ($query, $category_id)  => $query->where('category_id', $category_id))
            ->when(request('order_by'), fn ($query, $field) => $query->orderBy($field, request('direction')))
            ->when(request('status') !== null,  fn ($query) => $query->status())
            ->when(request('search'), fn ($query) => $query->search());
    }

    public static function getStatusCount(int $status): int
    {
        return self::where('status', $status)->count();
    }

    public function getImagesAttribute()
    {
        $images = $this->getMedia('images');

        if (!$images->isEmpty()) return $images;

        return collect([
            ['original_url' => '/storage/product-images/no-image.png']
        ]);
    }
}
