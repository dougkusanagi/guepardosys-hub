<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RahulHaque\Filepond\Facades\Filepond;

class ProductImageService
{
    public static function create(Request $request, Product $product)
    {
        $count_images = countProductImages($product);

        foreach ($request->filepond_files as $index => $value) {
            $filepondField = Filepond::field($value);
            $filepondField->moveTo(env('PRODUCT_IMAGES_ROOT') . DS . $product->id . DS . $index + $count_images);
        }
    }

    private static function removeQueryParameters($image)
    {
        return parse_url($image)['path'];
    }

    private static function getRelativePath(String $request_image): String
    {
        $path = basename(dirname($request_image));
        $file = basename($request_image);
        return "{$path}/{$file}";
    }

    public static function delete(String $request_image)
    {
        $request_image = self::removeQueryParameters($request_image);
        $full_path = self::getRelativePath($request_image);
        Storage::disk(config('filepond.disk', 'public'))->delete($full_path);
    }

    public static function renameAscending(Product $product)
    {
        collect(getProductImagesAll($product))
            ->sort()                    // sort ascending by filename
            ->values()                  // reindex for renaming files again 0.jpg, 1.png, etc...
            ->each(function ($image, $index) {
                ['dirname' => $dirname, 'extension' => $extension] = pathinfo($image);
                rename($image, $dirname . DS . "{$index}.{$extension}");
            });
    }
}
