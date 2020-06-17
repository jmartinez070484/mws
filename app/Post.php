<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TrivitaPost;

class Post extends Model
{
    protected $table = 'posts';

    /*

		Trivita Post

    */
	public function trivita_post(){
		return $this -> type === 2 ? $this->hasOne(TrivitaPost::class,'id','trivita_post_id') : [];
	}
}
