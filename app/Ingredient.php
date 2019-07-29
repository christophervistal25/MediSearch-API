<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model 
{
    protected $fillable = ['medicine_id', 'name'];

    public function medicine()
    {
        return $this->belongsTo('App\Medicine');
    }
}
