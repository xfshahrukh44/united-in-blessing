<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBoards extends Model
{
    use Uuids, HasFactory, SoftDeletes;

//    protected $primaryKey = null;
//    public $incrementing = false;

    protected $fillable = ['user_id', 'username', 'board_id', 'parent_id', 'user_board_roles', 'position'];

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

    public function parent()
    {
        return $this->belongsTo(UserBoards::class, 'parent_id', 'user_id');
    }

    public function board_parent($board_id){
        return $this->parent()->where('board_id', $board_id)->first();
    }

    public function children()
    {
        return $this->hasMany(UserBoards::class, 'parent_id', 'user_id');
    }

    public function child_nodes()
    {
        return $this->hasMany(UserBoards::class, 'parent_id', 'user_id')->where('board_id', $this->board_id);
    }

    public function newbies()
    {
        return $this->hasMany(UserBoards::class, 'board_id', 'board_id')->where('user_board_roles', 'newbie');
    }

    public function undergrads()
    {
        return $this->hasMany(UserBoards::class, 'board_id', 'board_id')->where('user_board_roles', 'undergrad');
    }

    /**
     * Get Children By Board ID
     *
     * @param $board_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function boardChildren($board_id)
    {
        return $this->children()->where('board_id', $board_id)->with('board.gifts')->whereHas('user')->orderBy('position')->get();
    }

    public function boardMember($board_id, $user_board_role, $position){
        return $this->where('board_id', $board_id)
            ->where('user_board_roles', $user_board_role)
            ->where('position', $position)
            ->first();
    }

    public function getFormattedUserBoardRolesAttribute() {
        return [
            'pregrad' => 'Pre-Grad',
            'undergrad' => 'undergrad',
            'newbie' => 'newbie',
            'grad' => 'grad'
        ][$this->user_board_roles];
    }
}
