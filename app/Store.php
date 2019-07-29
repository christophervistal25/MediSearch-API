<?php

namespace App;


use App\Pharmacist;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


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

    public function pharmacists()
    {
        return $this->hasMany('App\Pharmacist');
    }

    public function assignPharmacist($pharmacist)
    {
        $data = new Pharmacist([
            'fullname'   => $pharmacist->fullname,
            'email'      => $pharmacist->email,
            'contact_no' => $pharmacist->contact_no,
            'address'    => $pharmacist->address,
            'password'   => Hash::make($pharmacist->password),
        ]);
    }

}
