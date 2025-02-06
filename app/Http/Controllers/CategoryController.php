<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getAll(): JsonResponse
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'categories' => $categories
        ], 200);
    }

    public function add(): JsonResponse
    {
        $categories = Category::all();
        $list = [];
        foreach ($categories as $category) {
            $list [] = [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }
        return response()->json([
            'success' => true,
            'categories' => $list
        ], 200);
    }

    public function save(Request $request): JsonResponse
    {
        $input = $request->only(['id', 'name', 'description']);

        if (isset($input['id'])) {
            try {
                $category = Category::find($input['id']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return response()->json(['success' => false]);
            }
        } else {
            $category = new Category();
        }

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

        $category->name = $input['name'];
        $category->description = $input['description'];
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category added correctly',
            'categories' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    /* public function get($categoryId): JsonResponse
    {
        Gate::authorize('view', Category::class);
        $category = Category::find($categoryId);
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
    } */

    public function destroy(string $id): JsonResponse
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }
}
