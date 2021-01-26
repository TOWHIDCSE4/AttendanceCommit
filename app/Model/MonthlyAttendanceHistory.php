<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyAttendanceHistory extends Model
{
    //
    protected $table = 'monthly_attendance_history';
    protected $fillable = ['history_id','monthly_attendance_id','operate_at','status'];
    protected $primaryKey='history_id';
    public $timestamps = false;
}
