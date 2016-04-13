<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    protected $fillable = [
        'email',
    ];
    protected $hidden = [
        'remember_token',
    ];
    protected $primaryKey = 'id';

    public function Sub2NewTv()
    {
        return $this->hasOne('App\Sub2NewTv');
    }
}
