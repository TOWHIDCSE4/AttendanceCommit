<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model
{
    //
    protected $table = 'holiday_type';
    protected $fillable = ['holiday_id','holiday_name','holiday_group'];
    protected $primaryKey='holiday_id';
    public $timestamps = false;
}
