<?php

namespace App;

use Moloquent\Eloquent\Model as Moloquent;
use Moloquent\Eloquent\HybridRelations;
use Moloquent\Eloquent\SoftDeletes;

class Post extends Moloquent
{
    use HybridRelations, SoftDeletes;

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
