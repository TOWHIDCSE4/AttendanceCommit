<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    //
    protected $table = 'authority';
    protected $fillable = ['authority_id','authority_name'];
    protected $primaryKey='authority_id';
    public $timestamps = false;
}
