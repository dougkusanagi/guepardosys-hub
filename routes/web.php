<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('product.index'))->name('dashboard');

    // Route::resource('/product', ProductController::class);
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::delete('/delete-image/{product}', [ProductImageController::class, 'deleteImage'])->name('image.delete');

    Route::get('/categories', fn () => inertia('Category/Index'))->name('category.index');
});

require __DIR__ . '/auth.php';
require app_path() . '/constants.php';
