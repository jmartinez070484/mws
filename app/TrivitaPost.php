<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrivitaPost extends Model
{
	protected $table = 'trivita_posts';

	/*

		API Update

    */
    public function apiUpdate(){
    	if($this -> id && $this -> type === 1){
    		$postApiUrl = Str::replaceArray(env('TRIVITA_API_BLOG'));
            $httpRequestPost = Http::get($postApiUrl);

            if($httpRequestPost -> ok()){
                $postData = $httpRequestPost -> json();
            }
    	}
    }

    /*

		Slug

    */
    public function getRouteKeyName(){
    	return 'slug';
	}
}
