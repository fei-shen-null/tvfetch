<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    protected $table='tv';
    protected $primaryKey='tv_id';
    protected $fillable=['tv_id','day_of_week','name_cn','name_en','genre','channel','status'];
}
