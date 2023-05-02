<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ProductModelPrefix extends Model
{
    use HasFactory;

	public function productModel(): HasMany
	{
		return $this->hasMany(ProductModel::class);
	}
}
