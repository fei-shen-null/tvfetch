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

    public static function byEmail($email)
    {

        return User::firstOrCreate(compact('email'));
    }

    public function sub2NewTv()
    {
        return $this->hasOne('App\Sub2NewTv');
    }

    public function subTv()
    {
        return $this->hasMany('App\SubTv');
    }

}
