<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Uuids, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invited_by', 'username', 'first_name', 'last_name', 'email', 'phone', 'role', 'timezone', 'is_blocked', 'password', 'user_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function boards()
    {
        return $this->hasMany(UserBoards::class, 'user_id', 'id');
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by', 'id');
    }

    public function inviters()
    {
        return $this->hasMany(User::class, 'invited_by', 'id');
    }

    public function acceptedGiftsInviters(){
        return $this->hasMany(User::class, 'invited_by', 'id')
            ->whereHas('giftLogs', function ($q){
                $q->where('status', 'accepted');
            });
    }

    public function giftLogs(){
        return $this->hasMany(GiftLogs::class, 'sent_by');
    }

    public function latestPassword()
    {
        return $this->hasOne(UserProfileChangedLogs::class, 'user_id', 'id')
            ->where('key', 'password')->latest();
    }

    public function usernameLogs()
    {
        return $this->hasMany(UserProfileChangedLogs::class, 'user_id', 'id')
            ->where('key', 'username');
    }

    public function sentByGifts(){
//        return GiftLogs::where("sent_by", $this->id)->sum('amount');
        return $this->hasMany(GiftLogs::class, 'sent_by', 'id');
    }

    public function sentToGifts(){
        return $this->hasMany(GiftLogs::class, 'sent_to', 'id');
    }

    public function sumAllGift(){
        return GiftLogs::where('sent_by', $this->id)->orWhere('sent_to', $this->id)->get();
//        return $this->hasMany(GiftLogs::class, )
    }

}
