<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter_sent extends Model
{
    protected $table='newsletter_sent';

   protected $fillable = [
       'news_letter_id','subject','content'
    ]; 

}
