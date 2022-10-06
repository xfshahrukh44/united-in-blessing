<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellWatch extends Model
{
    protected $table = 'sell_watches';
    protected $fillable = ['name', 'phone', 'email', 'location', 'watch_name', 'img1', 'img2', 'img3', 'img4', 'status'];
}
