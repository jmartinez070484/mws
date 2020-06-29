<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feed';
    protected $fillable = ['reference','created_at','active','store_id','content','image']; 

    public $timestamps = true;
}
