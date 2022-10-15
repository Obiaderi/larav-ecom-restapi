<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'description' => 'required',
            'status' => 'sometimes',
            'meta_title' => 'required|max:191',
            'meta_keywords' => 'required|max:191',
            'meta_description' => 'required|max:191',
        ]);

        $validate['status'] = $request->status ? 1 : 0;

        $category = Category::create($validate);

        return response()->json([
            'status' => 200,
            'message' => 'Category created successfully',
            'category' => $category
        ]);

    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'description' => 'required',
            'status' => 'sometimes',
            'meta_title' => 'required|max:191',
            'meta_keywords' => 'required|max:191',
            'meta_description' => 'required|max:191',
        ]);

        $validate['status'] = $request->status ? 1 : 0;

        $category = Category::findOrFail($id);

        $category->update($validate);

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully',
        ]);
    }

    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }


}
