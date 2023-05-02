<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Enums\ProductStatusEnum;
use App\Models\ProductModelPrefix;
use App\Services\ProductImageService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use App\Services\ProductModelService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Product/Index', [
            'product_pages' =>
            Product::query()
                ->whereBelongsTo(auth()->user()->company)
                ->with('category')
                ->filter()
                ->paginate(request('per_page'))
                ->withQueryString(),
            'product_status_array' => ProductStatusEnum::asSelectArray(),
            'product_status_all' => $this->getProductStatusAll(),
            'product_count' => ProductService::getStatusCounts(),
            'categories_all' => Category::whereBelongsTo(auth()->user()->company)->get(),
            'per_page' => request('per_page', Product::perPage),
        ]);
    }

    public function getProductStatusAll()
    {
        $product_status_all = [];
        foreach (ProductStatusEnum::asArray() as $index => $status) {
            $product_status_all[$index] = (string) $status;
        }

        return collect($product_status_all);
    }

    public function create()
    {
        // Session::now('info', 'Você não tem permissão para criar produtos');

        return inertia('Product/Create', [
            'product_model_prefixes' => ProductModelPrefix::all(),
            'product_status_enum' => collect(ProductStatusEnum::asSelectArray())
                ->map(fn ($status, $index) => ['id' => $index, 'name' => $status]),
            'categories_all' => Category::all(),
        ]);
    }

    public function edit(Product $product, User $user)
    {
        $this->authorize('update', $product);

        return inertia('Product/Edit', [
            'product' => $product,
            'product_model_prefixes' => ProductModelPrefix::all(),
            'product_status_enum' => collect(ProductStatusEnum::asSelectArray())
                ->map(fn ($status, $index) => ['id' => $index, 'name' => $status]),
            'categories_all' => Category::all(),
            'images' => getProductImagesPublicPaths($product),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated() + ['company_id' => auth()->user()->company_id]);
        ProductModelService::register($request, $product);
        ProductImageService::create($request, $product);

        return to_route('product.edit', $product)
            ->with('success', 'Produto cadastrado com sucesso');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());
        ProductModelService::update($request, $product);
        ProductImageService::create($request, $product);

        return to_route('product.index')
            ->with('success', 'Produto atualizado com sucesso');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()
            ->with('success', 'Produto removido com sucesso');
    }
}
