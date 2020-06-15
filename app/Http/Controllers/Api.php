<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;
use App\Store;

class Api extends Controller
{
    /*

		Construct

    */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /*

        Stores

    */
    public function stores(Request $request){
        $response = ['success'=>true];  

        $exitCode = Artisan::call('stores:update',[
            '--queue'=>'default'
        ]);

        return response($response);
    }

    /*

        Store

    */
    public function store(Request $request,Store $store){
        $store -> apiUpdate();
        $response = ['success'=>true,'store'=>$store];  

        return response($response);
    }

    /*

        Feed

    */
    public function feed(Request $request,Store $store){
        $store -> apiFeedUpdate();
        $response = ['success'=>true,'store'=>$store];  

        return response($response);
    }

    /*

        Products

    */
    public function products(Request $request,Store $store){
        $store -> apiProductListUpdate();
        $response = ['success'=>true,'store'=>$store];  

        return response($response);
    }


    /*

		Post

    */
	public function post(Request $request,Post $post){
        $id = $request -> route() -> parameter('id');
        $post = Post::where('post_id',$id) -> first();
        
        if(!$post){
            $post = new Post;
            $post -> post_id = $id;
        }

        $post -> apiUpdate();

		$response = ['success'=>true,'post'=>$post];

		return response($response);
	}

    /*

        Index

    */
    public function user(Request $request){
        $response = ['success'=>true,'user'=>Auth::user()];

        return response($response);
    }
}
