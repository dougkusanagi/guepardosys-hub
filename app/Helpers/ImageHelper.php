<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('getProductImagePaths')) {
	function getProductImagePaths(Product $product, $disk = 'public'): array
	{
		return Storage::disk($disk)->files(env('PRODUCT_IMAGES_ROOT') . DS . $product->id);
	}
}

if (!function_exists('getProductImagesPublicPaths')) {
	function getProductImagesPublicPaths(Product $product, $disk = 'public'): array
	{
		// return array_map(function ($image) {
		// 	return '/storage/' . $image . '?uuid=' . Str::uuid();
		// }, getProductImagePaths($product, $disk));
		return array_map(
			fn ($image) => '/storage/' . $image . '?uuid=' . Str::uuid(),
			getProductImagePaths($product, $disk)
		);
	}
}

if (!function_exists('getProductImagesPath')) {
	function getProductImagesPath(Product $product)
	{
		return public_path('storage' . DS . env('PRODUCT_IMAGES_ROOT') . DS . $product->id);
	}
}

if (!function_exists('getProductImagesAll')) {
	function getProductImagesAll(Product $product): array
	{
		return glob(getProductImagesPath($product) . DS . '*.' . env('PRODUCT_IMAGE_EXTENSIONS'), GLOB_BRACE);
	}
}

if (!function_exists('countProductImages')) {
	function countProductImages(Product $product): int
	{
		return count(getProductImagesAll($product));
	}
}
