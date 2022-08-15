<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftLogs extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['sent_by', 'sent_to', 'board_id', 'amount', 'status'];
}
