<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Post;

class Posts extends Component
{
    public $limit;
    public $title;
    public $posts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($limit = null, $title = null)
    {
        $posts = $limit ? Post::where('active',1) -> orderBy('created_at','desc') -> limit($limit) -> get() : Post::where('active',1) -> orderBy('created_at','desc') -> limit(5) -> get();

        $this -> limit = $limit ? $limit : 1;
        $this -> title = $title ? $title : null;
        $this -> posts = $posts ? $posts : [];
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
