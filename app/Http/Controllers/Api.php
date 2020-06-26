<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Post;
use App\Store;
use App\TrivitaPost;

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

        Trivita API blog posts

    */
    public function trivita_post(Request $request,$id){
        $response = ['success'=>false,'id'=>$id]; 

        if($id){
            $httpRequestPosts = Http::get(env('TRIVITA_API_POSTS').$id);
            
            if($httpRequestPosts -> ok()){
                $post = $httpRequestPosts -> json();

                if(isset($post['success']) && $post['success']){
                    $postData = $post['post'];
                    $post = TrivitaPost::find($postData['ID']);

                    if(!$post){
                        $post = new TrivitaPost;
                        $post -> id = $postData['ID'];
                    }

                    $post -> created_at = $postData['post_date'];
                    $post -> name = $postData['post_title'];
                    $post -> slug = $postData['post_name'];
                    $post -> excerpt = $postData['post_excerpt'];
                    $post -> content = $postData['post_content'];
                    $post -> image = isset($postData['featured_image']) ? $postData['featured_image'] : null;
                    $post -> save();

                    $response['success'] = true;
                    $response['post'] = $post;
                }
            }
        }

        return response($response);
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
        $response = ['success'=>true,'feed'=>$store -> feed -> take(20)];  

        return response($response);
    }

    /*

        Products

    */
    public function products(Request $request,Store $store){
        $store -> apiProductListUpdate();

        try{
            $store -> products -> content = json_decode($store -> products -> content);
        }catch(Exception $exception){

        }

        $response = ['success'=>true,'products'=>$store -> products];  

        return response($response);
    }

    /*

        Products

    */
    public function blog_post(Request $request,Store $store){
        $store -> apiPostsUpdate(true);
        $posts = Post::where('active',1) -> where('store_id',$store -> id) -> orderBy('created_at','desc') -> limit(20) -> get();
        $response = ['success'=>true,'posts'=>$posts];  

        return response($response);
    }

    /*

        User

    */
    public function user(Request $request){
        $response = ['success'=>true,'user'=>Auth::user()];

        return response($response);
    }
}
