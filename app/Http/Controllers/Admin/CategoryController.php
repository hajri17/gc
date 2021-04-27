<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryEditRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.categories.index');
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category($request->only('name', 'category_id'));
            $category->save();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to insert category.',
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'success' => 'Category added successfully',
                'id' => $category->id,
            ]);
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        $categories = Category::query()
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact('categories', 'category'));
    }

    public function update(CategoryEditRequest $request, Category $category)
    {
        try {
            $category->update($request->only('name', 'category_id'));
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to update category with id: ' . $category->id,
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'success' => 'Category updated successfully',
                'id' => $category->id,
            ]);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to delete category with id: ' . $category->id,
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'success' => 'Category deleted successfully.',
                'id' => $category->id,
            ]);
    }
}
