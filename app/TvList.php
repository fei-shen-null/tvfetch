<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TvList
 *
 * @mixin \Eloquent
 */
class TvList extends Model
{
    public $timestamps = false;
    protected $fillable = ['tv_id'];
    protected $primaryKey = 'tv_id';
    protected $table = 'tv_list';
}
