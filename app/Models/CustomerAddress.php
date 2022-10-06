<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = "customer_addresses";
    protected $fillable = ["customer_id","first_name","last_name","phone_no","phone_no_code","title","address","city","company_name","zip_code","country","state","shipping_billing","save_check"];

    public function user(){
        return $this->belongsTo(Customers::class,'customer_id','id');
    }

}
