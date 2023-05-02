<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
	use HasFactory;

	protected $guarded = [];
	protected $with = ['productModelPrefix'];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function productModelPrefix()
	{
		return $this->belongsTo(ProductModelPrefix::class);
	}

	public static function getNextProductModelDigit(ProductModelPrefix $product_model_prefix): Int
	{
		$last_product_model = self::getLastProductModelDigit($product_model_prefix);

		return $last_product_model ? $last_product_model->digits + 1 : 1;
	}

	public static function getLastProductModelDigit(ProductModelPrefix $product_model_prefix)
	{
		return ProductModel::query()
			->whereBelongsTo($product_model_prefix)
			->orderByDesc('digits')
			->first();
	}
}
