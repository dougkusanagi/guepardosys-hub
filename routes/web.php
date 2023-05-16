<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('product.index'))
        ->name('dashboard');

    Route::resource('/product', ProductController::class);

    Route::resource('/category', CategoryController::class);

    Route::delete('/delete-image/{media_item}', [ProductImageController::class, 'deleteImage'])
        ->name('image.delete');
});

require __DIR__ . '/auth.php';
require app_path() . '/constants.php';
