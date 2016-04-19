<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
