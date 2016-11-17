<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Moloquent\Eloquent\HybridRelations;

class User extends Model
{
    use HybridRelations;

    use Authenticatable;

    protected $primaryKey = 'id';

    protected $connection = 'mysql';

//    protected $collection = 'users';

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'social'];

    protected $hidden = ['password', 'pivot'];

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
