<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationReceiver extends Model
{
    //
    protected $table = 'notification';
    protected $fillable = ['notification_id','receiver_user_id'];
    public $timestamps = false;
}
