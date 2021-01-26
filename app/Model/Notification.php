<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notification';
    protected $fillable = ['notification_id','subject','content','sender_id','receiver_id','position_id','date_sending',
        'date_creation','notification_type','holiday_information_id','status'];
    protected $primaryKey='notification_id';
    public $timestamps = false;
}
