<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
