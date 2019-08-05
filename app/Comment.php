<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{
    protected $fillable = ['user_id', 'body', 'commentable_id', 'commentable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
    	return $this->hasMany('App\Reply');
    }
}
