<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=['category_id','name','type','purchase_price','sale_price','minimum_amount'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public static function obtener($products){
        $listProduct=[];
        $listResponse=[];
        $listPrueba=[];
        foreach($products as $product){
            $response=[
                'name'=>$product->name,
                'category'=>$product->category
            ];
            $prueba=Product::find($product->id);
            if($prueba->name == $response['name']){
                $listPrueba=
                ['name'=>$product->name,
                 'prueba'=>'',       ];
            }
            if ($product->stock == 0) {
                $listPrueba['stock'] = $product->stock;
            }

            $listResponse[] = $listPrueba;
        }

        return $listResponse;
    }
}
