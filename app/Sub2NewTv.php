<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub2NewTv extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id'];
    protected $primaryKey = 'user_id';
    protected $table = 'subscribe_to_new_tv';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
