<?php

namespace App\Services;

use App\Enums\ProductStatusEnum;
use App\Models\Product;

class ProductService
{

    public function getStatusCountsArray()
    {
        $totalActive    = auth()->user()->company->products()->whereStatus(ProductStatusEnum::Active)->count();
        $totalInactive  = auth()->user()->company->products()->whereStatus(ProductStatusEnum::Inactive)->count();
        $totalWaiting   = auth()->user()->company->products()->whereStatus(ProductStatusEnum::Waiting)->count();
        $total          = auth()->user()->company->products()->count();

        return collect(compact('totalActive', 'totalInactive', 'totalWaiting', 'total'));
    }

    public static function getStatusCounts()
    {
        return (new static)->getStatusCountsArray();
    }
}
