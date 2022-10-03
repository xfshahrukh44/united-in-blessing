<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBoards extends Model
{
    use Uuids, HasFactory;

//    protected $primaryKey = null;
//    public $incrementing = false;

    protected $fillable = ['user_id', 'board_id', 'parent_id', 'user_board_roles', 'position'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function board()
    {
        return $this->belongsTo(Boards::class, 'board_id', 'id');
    }

    public function boardGrad()
    {
        return $this->belongsTo(UserBoards::class, 'board_id', 'board_id')->where('user_board_roles', 'grad')
            ->with('user');
    }

    /**
     * Get board of specific amount
     * @param $amount
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boardAmount($amount){
        return $this->belongsTo(Boards::class, 'board_id', 'id')->where('amount', $amount);
    }

    public function parent()
    {
        return $this->belongsTo(UserBoards::class, 'parent_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(UserBoards::class, 'parent_id', 'user_id');
    }

    public function newbies()
    {
        return $this->hasMany(UserBoards::class, 'board_id', 'board_id')->where('user_board_roles', 'newbie');
    }

    /**
     * Get Children By Board ID
     *
     * @param $board_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function boardChildren($board_id)
    {
        return $this->children()->where('board_id', $board_id)->get();
    }
}
