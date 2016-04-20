<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Episode
 *
 * @property-read \App\Tv $tv
 * @mixin \Eloquent
 */
class Episode extends Model
{
    protected $table = 'episodes';
    protected $primaryKey = 'id';
    protected $fillable = ['tv_id', 'href', 'txt'];

    public function tv()
    {
        return $this->belongsTo('App\Tv');
    }
}
