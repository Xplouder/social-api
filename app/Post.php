<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Post extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mongodb';

    protected $collection = 'posts';

//    protected $table = 'posts';

    protected $fillable = ['body_text', 'body_image', 'public', 'user_id'];

    protected $dates = ['deleted_at'];

//    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
