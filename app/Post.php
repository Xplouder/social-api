<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['body_text', 'body_image', 'public', 'user_id'];

    protected $dates = ['deleted_at'];

//    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
