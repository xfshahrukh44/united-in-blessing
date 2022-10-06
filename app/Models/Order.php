<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='orders';

    protected $fillable = [
        'order_no', 'customer_id', 'customer_name', 'customer_email', 'sub_total', 'tax', 'total_amount', 'shipping_address',
        'order_status', 'status', 'discount','shipping_cost','phone_no','shipping_country','shipping_state','shipping_city',
        'shipping_zip','billing_country','billing_state','billing_city','billing_address','billing_zip'
    ];

    public function customer(){
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
