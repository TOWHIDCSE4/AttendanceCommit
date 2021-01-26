<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $table = 'department';
    protected $fillable = ['department_id','department_name','description'];
    protected $primaryKey='department_id';
    public $timestamps = false;
}
