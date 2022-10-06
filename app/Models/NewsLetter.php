<?php

namespace App\Models;
use App\Newsletter_sent;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    protected $table = 'news_letter';
    protected $fillable = [
        'email', 'status'
    ];
 
    public function newslettersents()
    {
        return $this->hasOne(Newsletter_sent::class, 'news_letter_id', 'id');
    }

}
