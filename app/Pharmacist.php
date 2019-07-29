<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'fullname', 'store_id', 'email', 'contact_no', 'address', 'password'
    ];

     /* The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function store()
    {
        return $this->belongsTo('App\Store');
    }


}
