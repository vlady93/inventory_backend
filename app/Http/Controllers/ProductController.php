<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\EmailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $emailService;

    public function __construct(EmailServices $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }


    public function store(Request $request)
    {
        $input = $request->all();
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
        $product = Product::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Product added correctly',
            'products' => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $category = Product::find($id);
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

    public function getProduct(){
        $poleras=Product::all();
        $data=Product::obtener($poleras);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }


    public function sendEmail(Request $request)
    {
        $cuenta='123456';
        $correlativo=1;
        $moneda='BOB';
        $monto=32;
        $label='FORTALEZA CUENTA OFICIAL';
        $correo='vlady3000hc@gmail.com';
        try {
            $this->emailService->sendEmailWithCode($cuenta);
            return response()->json(['message' => 'Correo enviado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
