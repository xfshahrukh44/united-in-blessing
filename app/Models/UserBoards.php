<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBoards extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['user_id', 'board_id', 'user_board_roles', 'position'];
}
