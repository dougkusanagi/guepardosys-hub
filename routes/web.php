<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('product.index'))
        ->name('dashboard');

    Route::resource('/product', ProductController::class);

    Route::delete('/delete-image/{media_item}', [ProductImageController::class, 'deleteImage'])
        ->name('image.delete');

    Route::get('/categories', fn () => inertia('Category/Index'))
        ->name('category.index');
});

require __DIR__ . '/auth.php';
require app_path() . '/constants.php';
