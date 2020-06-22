<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\Mws;
use App\Post;
use App\TrivitaPost;

class Posts extends Component
{
    public $mws;
    public $title;
    public $posts;
    public $pagination;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($limit = null, $title = null, $pagination = null)
    {
        $mws = Mws::instance();
        $store = $mws -> store;

        if($pagination){
            $posts = $limit ? Post::where('active',1) -> where('store_id',$store -> id) -> orderBy('created_at','desc') -> paginate($limit) : Post::where('active',1) -> where('store_id',$store -> id) -> orderBy('created_at','desc') -> paginate(5);
        }else{
            $posts = $limit ? Post::where('active',1) -> where('store_id',$store -> id) -> orderBy('created_at','desc') -> limit($limit) -> get() : Post::where('active',1) -> where('store_id',$store -> id) -> orderBy('created_at','desc') -> limit(5) -> get();
        }
        
        foreach($posts as $key => $value){
            if($value -> type === 2){
                $trivitaPost = TrivitaPost::find($value -> trivita_post_id);

                if($trivitaPost){
                    $posts[$key] = $trivitaPost;
                    $posts[$key] -> reference_id = $value -> id;
                }
            }
        }

        $this -> mws = $mws;
        $this -> title = $title ? $title : null;
        $this -> posts = $posts ? $posts : [];
        $this -> pagination = $pagination ? true : false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.posts');
    }
}
