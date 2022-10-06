<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = "collections";

    protected $fillable = ['name','order_by_no','status'];

    public function collectionProducts(){
        return $this->hasMany(CollectionProduct::class,'collection_id','id');
    }
}
