<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_name',
        'content'
    ];

    protected $casts = [
        'content' => 'json'
    ];
}
