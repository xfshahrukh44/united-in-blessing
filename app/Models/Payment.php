<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";
    protected $fillable = [
        'order_id', 'amount','card_id','pay_method_name','name_on_card','response_code','transaction_id','auth_id','message_code','quantity'
    ];

}
