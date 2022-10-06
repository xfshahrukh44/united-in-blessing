<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'order_id','product_id','variant_id', 'product_per_price', 'product_qty', 'product_options', 'length', 'width',
        'height', 'weight', 'tax','product_subtotal_price',
        'status'
    ];

    protected $casts = [
        'product_options' => 'json'
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
