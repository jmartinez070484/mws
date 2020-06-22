<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Store;
use App\Post;

class UpdateStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:update {posts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stores via API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store');
        $posts = $this->argument('posts');
        
        if($httpRequest -> ok()){
            $stores = $httpRequest -> json();

            foreach($stores as $storeData){
                $domain = isset($storeData['Settings']['Domain']) ? $storeData['Settings']['Domain'] : null;

                if($domain){
                    $store = Store::where('domain',$domain) -> first();
                    
                    if(!$store){
                        $store = new Store;
                        $store -> domain = $domain;
                    }

                    $store -> apiUpdate();
                    $store -> apiFeedUpdate();
                    $store -> apiProductListUpdate();

                    if($posts){
                        Post::where('store_id',$store -> id) -> delete();

                        $store -> apiPostsUpdate(true);
                        $this->info($store -> name.' - Store Posts Updated!');
                    }

                    $this->info($store -> name.' - Store Updated!');
                }
            }
        }

        $this->info('Stores Update Completed!');
    }
}
