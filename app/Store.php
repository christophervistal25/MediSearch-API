<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Store extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'located_at'
    ];

    public function owner()
    {
    	return $this->belongsToMany('App\Owner');
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Medicine');
    }

}
