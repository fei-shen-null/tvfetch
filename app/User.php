<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property-read \App\Sub2NewTv $sub2NewTv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubTv[] $subTv
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
        $user = static::hasEmail($email);
        if (is_null($user)) {//new user
            //try email first
            \Mail::send('emails.welcome', [], function ($m) use ($email) {
                $m->from(env('MAIL_FROM'))->subject('Welcome to TvFetch');
                $m->to($email);
            });
            $user = User::create(compact('email'));
            Sub2NewTv::create(['user_id' => $user->id]);
        }
        return $user;
    }

    /**
     * @param $email
     * @return User|null
     */
    public static function hasEmail($email)
    {
        return static::where('email', $email)->first();
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
