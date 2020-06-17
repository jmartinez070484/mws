<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\Mws;
use App\Post;
use App\TrivitaPost;

class Posts extends Component
{
    public $mws;
    public $limit;
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

        if($pagination){
            $posts = $limit ? Post::where('active',1) -> orderBy('created_at','desc') -> paginate($limit) : Post::where('active',1) -> orderBy('created_at','desc') -> paginate(5);
        }else{
            $posts = $limit ? Post::where('active',1) -> orderBy('created_at','desc') -> limit($limit) -> get() : Post::where('active',1) -> orderBy('created_at','desc') -> limit(5) -> get();
        }

        foreach($posts as $key => $value){
            if($value -> type === 2){
                $posts[$key] = TrivitaPost::find($value -> trivita_post_id);
                $posts[$key] -> reference_id = $value -> id;
            }
        }

        $this -> mws = $mws;
        $this -> limit = $limit ? $limit : 1;
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
