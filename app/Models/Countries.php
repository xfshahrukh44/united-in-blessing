<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = "countries";

    protected $fillable = ['name', 'iso3', 'numeric_code', 'phonecode', 'iso2'];

    public function states(){
        return $this->hasMany(States::class,'country_id','id');
    }
}
