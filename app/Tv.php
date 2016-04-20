<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tv
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubTv[] $subTv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Episode[] $episode
 * @mixin \Eloquent
 */
class Tv extends Model
{
    protected $table='tv';
    protected $fillable = ['id', 'day_of_week', 'name_cn', 'name_en', 'genre', 'channel', 'status'];

    public function subTv()
    {
        return $this->hasMany('App\SubTv');
    }

    public function episode()
    {
        return $this->hasMany('App\Episode');
    }

}
