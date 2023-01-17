<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftLogs extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['sent_by', 'sent_to', 'board_id', 'amount', 'status'];

//    public function user()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }

    public function board()
    {
        return $this->belongsTo(Boards::class, 'board_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'sent_to', 'id');
    }

    public function userBoard() {
        return $this->hasMany(UserBoards::class, 'board_id', 'board_id');
    }

    public function userBoardPosition($board_id, $user_id)
    {
        return $this->userBoard()->where('board_id', $board_id)->where('user_id', $user_id)->first();
    }
}
