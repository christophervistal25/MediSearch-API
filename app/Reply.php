<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model 
{
    protected $fillable = ['comment_id', 'user_id', 'body'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function comment()
    {
        return $this->belongsTo('App\Reply');
    }
}
