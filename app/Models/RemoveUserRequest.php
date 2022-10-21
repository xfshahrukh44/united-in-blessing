<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemoveUserRequest extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'board_id', 'requested_by', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function board(){
        return $this->belongsTo(Boards::class, 'board_id');
    }

    public function requestedBy(){
        return $this->belongsTo(User::class, 'requested_by');
    }

}
