<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    //
    protected $table = 'passwordReset';
    protected $fillable = ['email','token','create_at'];
//    public $timestamps = true;
}
