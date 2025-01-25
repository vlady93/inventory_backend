<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'categories' => $categories
        ], 200);
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }
        $category = Category::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Category added correctly',
            'categories' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', Category::class);
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                'success' => true,
                'category' => $category,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }
    }


    public function update(Request $request, Category $category)
    {
        $input = $request->only(['name', 'description']);
        $validator = Validator::make($input, [
            'name' => 'required|exists:categories,id',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ])->setStatusCode(400);
        } else {
            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->save();
            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(null, 204);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }
}
