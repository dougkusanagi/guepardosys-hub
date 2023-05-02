<?php

namespace App\Services;

use App\Enums\ProductStatusEnum;
use App\Models\Product;

class ProductService
{
	public static function getStatusCountsSqlite()
	{
		$totalActive	= Product::getStatusCount(ProductStatusEnum::Active);
		$totalInactive	= Product::getStatusCount(ProductStatusEnum::Inactive);
		$totalWaiting	= Product::getStatusCount(ProductStatusEnum::Waiting);
		$total			= Product::all()->count();

		return collect(compact('totalActive', 'totalInactive', 'totalWaiting', 'total'));
	}

	public static function getStatusCounts()
	{
		// if (config('app.env') === 'local') return self::getStatusCountsSqlite();

		// Doesn't work with sqlite
		return Product::toBase()
			->selectRaw("count(IF(status = " . ProductStatusEnum::Active . " AND company_id = " . auth()->user()->company_id .", 1, null)) as totalActive")
			->selectRaw("count(IF(status = " . ProductStatusEnum::Inactive . " AND company_id = " . auth()->user()->company_id .", 1, null)) as totalInactive")
			->selectRaw("count(IF(status = " . ProductStatusEnum::Waiting . " AND company_id = " . auth()->user()->company_id .", 1, null)) as totalWaiting")
			->selectRaw("count(IF(company_id = " . auth()->user()->company_id .", 1, null)) as total")
			// ->selectRaw("count(*) as total")
			->first();

	}
}
