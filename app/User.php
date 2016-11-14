<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'social'];

    protected $hidden = ['password'];

    protected $dates = ['deleted_at'];

//    protected $with = ['posts'];

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id_1', 'user_id_2');
    }

}
