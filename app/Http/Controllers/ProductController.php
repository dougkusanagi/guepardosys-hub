<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Enums\ProductStatusEnum;
use App\Services\ProductImageService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use App\Services\ProductModelService;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::query()
                ->whereBelongsTo(auth()->user()->company)
                ->with(['category'])
                ->filter()
                ->orderBy('name')
                ->paginate(request('per_page', Product::perPage))
                ->withQueryString(),
            'product_status_array' => ProductStatusEnum::names(),
            'product_status_all' => ProductStatusEnum::array(),
            'product_count_array' => ProductService::getStatusCounts(),
            'categories_all' => Category::whereBelongsTo(auth()->user()->company)->get(),
            'per_page' => request('per_page', Product::perPage),
        ]);
    }

    public function create()
    {
        return inertia('Product/Create', [
            'product_status_enum' => collect(ProductStatusEnum::asSelectArray())
                ->map(fn ($status, $index) => ['id' => $index, 'name' => $status]),
            'categories_all' => Category::all(),
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
            'categories_all' => Category::whereBelongsTo(auth()->user()->company)->get(),
            'images' => $product->getMedia('images'),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());
        ProductImageService::registerCollections($request, $product);

        return back()
            ->with('success', 'Produto atualizado com sucesso');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()
            ->with('success', 'Produto removido com sucesso');
    }
}
