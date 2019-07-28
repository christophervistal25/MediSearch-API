<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'directions',
        'quantity', 'price'
    ];

    public function stores()
    {
        return $this->belongsToMany('App\Store');
    }

}
