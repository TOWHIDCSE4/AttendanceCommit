<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHolidayInformation extends Model
{
    //
    protected $table = 'user_holiday_information';
    protected $fillable = ['holiday_information_id','user_id','holiday_id','apply_date','start_date','end_date',
        'total_duration','status'];
    protected $primaryKey='holiday_information_id';
    public $timestamps = false;
}
