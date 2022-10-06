<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $table = 'email_settings';
    protected $fillable = ['mail_domain','mail_host','ssl','username','password','mail_port','from_address','status'];
}
