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
            'categories' => Category::paginated(),
            'per_page' => request('per_page', Category::perPage),
        ]);
    }

    public function create()
    {
        return inertia('Category/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create(
            $request->validated()
        );

        return to_route('category.edit', $category)
            ->with('success', 'Categoria cadastrado com sucesso');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return inertia('Category/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return back()
            ->with('success', 'Categoria atualizado com sucesso');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()
            ->with('success', 'Categoria removida com sucesso');
    }
}
