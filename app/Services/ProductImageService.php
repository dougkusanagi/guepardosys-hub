<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use RahulHaque\Filepond\Facades\Filepond;

class ProductImageService
{
    public static function registerCollections(StoreProductRequest|UpdateProductRequest $request, Product $product)
    {
        foreach (['images'] as $collection) {
            if (
                !$request->has($collection) ||
                $request->{$collection} === null
            ) continue;

            self::registerCollection(
                $request->{$collection},
                $product,
                $collection
            );
        }
    }

    private static function registerCollection(?array $files, Product $product, String $collection = 'default')
    {
        foreach ($files as $file) {
            $filepondField = Filepond::field($file)->getFile();
            $product
                ->addMedia($filepondField->getPathname())
                ->toMediaCollection($collection);
        }
    }
}
