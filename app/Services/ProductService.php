<?php

namespace App\Services;

use App\Enums\ProductStatusEnum;
use App\Models\Product;

class ProductService
{

    public function getStatusCountsArray()
    {
        $totalActive    = Product::whereStatus(ProductStatusEnum::Active)->count();
        $totalInactive  = Product::whereStatus(ProductStatusEnum::Inactive)->count();
        $totalWaiting   = Product::whereStatus(ProductStatusEnum::Waiting)->count();
        $total          = Product::count();

        return collect(compact('totalActive', 'totalInactive', 'totalWaiting', 'total'));
    }

    public static function getStatusCountArray()
    {
        return (new static)->getStatusCountsArray();
    }
}
