<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $fillable = ['user_id','user_name','email','phone','address','password','image_path','status_id'];
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
