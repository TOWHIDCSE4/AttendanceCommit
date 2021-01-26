<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    //
    protected $table = 'daily_attendance';
    protected $fillable = ['daily_attendance_id','user_id','date','checkin','checkout','break_time_hour',
        'total_working_hour','overtime_id','status'];
    protected $primaryKey='daily_attendance_id';
    public $timestamps = true;
}
