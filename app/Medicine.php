<?php

namespace App;

use App\Ingredient;
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

    public function ingredients()
    {
        return $this->hasMany('App\Ingredient');
    }

    public function stores()
    {
        return $this->belongsToMany('App\Store');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function addIngredients( array $ingredients = [])
    {
        foreach ($ingredients as $ingredient) {
            $model[] = new Ingredient(['name' => $ingredient]);
        }
        $this->ingredients()->saveMany($model);
    }

}
