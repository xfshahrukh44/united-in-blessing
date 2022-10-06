<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';
    protected $fillable = [
        'product_id', 'customer_id', 'author',
        'description', 'rating',
        'status'
    ];

    public function product(){
        return $this->belongsTo(Product::Class,'product_id','id');
    }

    public function customer(){
        return $this->belongsTo(Customers::Class,'customer_id','id');
    }
}
