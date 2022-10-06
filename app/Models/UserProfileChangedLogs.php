<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfileChangedLogs extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'key', 'value', 'old_value' , 'message', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
