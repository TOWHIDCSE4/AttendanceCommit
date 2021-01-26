<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyAttendance extends Model
{
    //
    protected $table = 'monthly_attendance';
    protected $fillable = ['monthly_id','start_date','end_date','user_id','status'];
    public $timestamps = false;
}
