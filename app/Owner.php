<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Owner extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'contact_no', 'address', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function stores()
    {
        return $this->belongsToMany('App\Store');
    }

    public function findByEmail(string $email, array $columns = ['*']) : Owner
    {
        return $this->where('email', $email)
                    ->first($columns);
    }

    public function scopefindStoreById($query, $value)
    {
        return $query->with(['stores' => function ($query) use ($value) {
            return $query->where('store_id', $value);
        }]);
    }

 
}
