<<<<<<< HEAD
=======
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function getAll(): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }


    public function save(Request $request): JsonResponse
    {
        $input = $request->only(['id', 'name', 'type', 'purchase_price', 'sale_price', 'minimum_amount', 'category_id']);

        if (isset($input['id'])) {
            try {
                $product = Product::find($input['id']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return response()->json(['success' => false]);
            }
        } else {
            $product = new Product();
        }

        $validator = Validator::make($input, [
            'name' => 'required|unique:products,name',
            'type' => 'required',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'minimum_amount'=>'required',
            'category_id'=>'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }
        $product->name = $input['name'];
        $product->type = $input['type'];
        $product->purchase_price = $input['purchase_price'];
        $product->sale_price = $input['sale_price'];
        $product->minimum_amount = $input['minimum_amount'];
        $product->category_id = $input['category_id'];
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product added correctly',
            'products' => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function get( $productId): JsonResponse
    {
        $product = Product::find($productId);

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => $product,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }
}
>>>>>>> 7fb7cbaf08f85a3e2fa58890765e066ed9fda1b8
