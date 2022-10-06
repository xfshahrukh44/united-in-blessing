<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';
    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'phone_no', 'city', 'state', 'country', 'address', 'status'];

    public function reviews()
    {
        return $this->hasMany(ProductReview::Class, 'id', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country', 'iso2');
    }

    public function state(){
        return $this->belongsTo(States::class, 'state', 'iso2');
    }
}
