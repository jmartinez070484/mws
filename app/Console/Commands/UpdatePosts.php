<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\TrivitaPost;

class UpdatePosts extends Command
{
    private $page;
    private $total_pages;
    private $posts;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update blog posts via API.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this -> page = 0;
        $this -> total_pages = 0;
        $this -> continue = true;
        $this -> posts = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fetchPosts = true;
        $page = 1;

        while($fetchPosts){
            $httpRequestPosts = Http::get(env('TRIVITA_API_POSTS').'?page='.($page));
        
            if($httpRequestPosts -> ok()){
                $posts = $httpRequestPosts -> json();

                foreach($posts['posts'] as $postData){
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
                }

                $fetchPosts = $posts['page'] != $posts['total_pages'] ? true : false;
                $page++;

                 $this->info('Posts Update Page '.$posts['page']);
            }else{
                $fetchPosts = false;
            }
        }

        $this->info('Posts Update Completed!');
    }
}
