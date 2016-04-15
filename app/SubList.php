<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubList extends Model
{
    protected $fillable = ['user_id', 'item_id'];
    protected $table = 'subscribe_tv';
}
