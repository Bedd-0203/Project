<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        return back();
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}