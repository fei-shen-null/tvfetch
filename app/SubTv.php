<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SubTv
 *
 * @property-read \App\User $user
 * @property-read \App\Tv $tv
 * @mixin \Eloquent
 */
class SubTv extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'tv_id'];
    protected $table = 'subscribe_tv';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tv()
    {
        return $this->belongsTo('App\Tv');
    }

}
