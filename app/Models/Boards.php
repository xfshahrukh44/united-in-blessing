<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boards extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $fillable = ['board_number', 'previous_board_number', 'amount', 'status', 'creation_method'];

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

    public function user_gift($user_id)
    {
        return $this->gifts()->where('sent_by', $user_id)->first();
    }

    public function user_boards ()
    {
        return $this->hasMany(UserBoards::class, 'board_id', 'id');
    }

    public function grad()
    {
        return $this->HasMany(UserBoards::class, 'board_id', 'id')->where('user_board_roles', 'grad')->first();
    }

    public function pregrad ($position)
    {
        return $this->HasMany (UserBoards::class, 'board_id', 'id')->where([
            'user_board_roles' => 'pregrad',
            'position' => $position,
        ])->first() ?? null;
    }

    public function undergrad ($position, $parent_id)
    {
        return $this->HasMany(UserBoards::class, 'board_id', 'id')->where([
            'user_board_roles' => 'undergrad',
            'position' => $position,
            'parent_id' => $parent_id,
        ])->first() ?? null;
    }

    public function newbie ($position, $parent_id)
    {
        return $this->HasMany(UserBoards::class, 'board_id', 'id')->where([
            'user_board_roles' => 'newbie',
            'position' => $position,
            'parent_id' => $parent_id,
        ])->first() ?? null;
    }
}
