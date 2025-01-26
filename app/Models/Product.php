<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['category_id', 'name', 'type', 'purchase_price', 'sale_price', 'minimum_amount'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
