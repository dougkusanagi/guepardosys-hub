<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return inertia('Category/Index', [
            'categories' => Category::query()
                ->whereBelongsTo(auth()->user()->company)
                ->filter()
                ->paginate(request('per_page'))
                ->withQueryString(),
            'per_page' => request('per_page', Category::perPage),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()
            ->with('success', 'Categoria removida com sucesso');
    }
}
