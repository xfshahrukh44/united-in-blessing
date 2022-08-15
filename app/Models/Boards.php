<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['board_number', 'amount', 'status'];
}
