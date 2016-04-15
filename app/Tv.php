<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    protected $table='tv';
    protected $fillable = ['id', 'day_of_week', 'name_cn', 'name_en', 'genre', 'channel', 'status'];

    public function subList()
    {
        return $this->hasMany('App\SubTv');
    }

}
