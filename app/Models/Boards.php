<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['board_number', 'amount', 'status'];

    public function members()
    {
        return $this->HasMany(UserBoards::class, 'board_id', 'id');
    }

    public function newbies()
    {
        return $this->HasMany(UserBoards::class, 'board_id', 'id')->where('user_board_roles', 'newbie');
    }

    public function gifts()
    {
        return $this->hasMany(GiftLogs::class, 'board_id');
    }
}
