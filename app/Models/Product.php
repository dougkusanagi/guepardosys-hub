<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
	use HasFactory;

	public const perPage = "25";
	protected $guarded = [];
	// protected $fillable = ['category_id'];
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

	public function getImagesAttribute(): array
	{
		$images = getProductImagesPublicPaths($this);

		if (!empty($images)) return $images;

		return ['/storage/product-images/no-image.png'];
	}

	public function images(): Attribute
	{
		$productImages = getProductImagesPublicPaths($this);

		$images = !empty($productImages)
			? $productImages
			: ['/storage/product-images/no-image.png'];

		return Attribute::make(
			get: fn () => $images,
		);
	}
}
