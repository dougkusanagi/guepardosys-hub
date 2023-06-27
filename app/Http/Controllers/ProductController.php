<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatusEnum;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImageService;
use App\Services\ProductService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::paginated(),
            'product_status_array' => ProductStatusEnum::arrayFliped(),
            'product_status_all' => ProductStatusEnum::array(),
            'product_count_array' => ProductService::getStatusCountArray(),
            'categories_all' => Category::query()
                ->select('id', 'name')
                ->whereBelongsTo(auth()->user()->company)
                ->get(),
            'per_page' => request('per_page', Product::perPage),
        ]);
    }

    public function create()
    {
        return inertia('Product/Create', [
            'product_status_enum' => ProductStatusEnum::asSelectArray(),
            'categories_all' => Category::query()
                ->select('id', 'name')
                ->whereBelongsTo(auth()->user()->company)
                ->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated() + ['company_id' => auth()->user()->company_id]);
        ProductImageService::registerCollections($request, $product);

        return to_route('product.edit', $product)
            ->with('success', 'Produto cadastrado com sucesso');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return inertia('Product/Edit', [
            'product' => $product,
            'product_status_enum' => ProductStatusEnum::asSelectArray(),
            'categories_all' => Category::query()
                ->select('id', 'name')
                ->whereBelongsTo(auth()->user()->company)
                ->get(),
            'images' => $product->getMedia('images')
                ->map(function (Media $media) {
                    return ['id' => $media->id, 'url' => $media->getUrl()];
                }),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());
        ProductImageService::registerCollections($request, $product);

        return to_route('product.edit', $product)
            ->with('success', 'Produto atualizado com sucesso');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return to_route('product.index')
            ->with('success', 'Produto removido com sucesso');
    }
}
