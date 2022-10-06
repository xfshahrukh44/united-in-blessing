<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionProduct extends Model
{
    protected $table = "collection_products";

    protected $fillable = ['collection_id','product_id'];

    public function collections(){
        return $this->belongsTo(Collection::class,'collection_id','id');
    }

    public function products(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
