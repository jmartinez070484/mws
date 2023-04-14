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
     * Store exceptions
     *
     * @var Array
     */
    protected $exceptions = [];

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
        $httpRequest = Http::accept('application/json') -> get(env('TRIVITA_WELLNESS_API').'/api/Store');
        $posts = $this->argument('posts');
        
        if($httpRequest -> ok()){
            $stores = $httpRequest -> json();

            if(!$stores){
                $stores = simplexml_load_string($httpRequest -> body());
            }
            
            foreach($stores as $storeData){
                $isObject = is_object($storeData);

                if($isObject && !in_array($storeData -> ID,$this -> exceptions) || !$isObject && !in_array($storeData['ID'],$this -> exceptions)){
                    if($isObject){
                        $domain = isset($storeData -> Settings -> Domain) ? $storeData -> Settings -> Domain : null;
                        $site = isset($storeData -> Settings -> SiteAddress) ? $storeData -> Settings -> SiteAddress : null;
                    }else{
                        $domain = isset($storeData['Settings']['Domain']) ? $storeData['Settings']['Domain'] : null;
                        $site = isset($storeData['Settings']['SiteAddress']) ? $storeData['Settings']['SiteAddress'] : null;
                    }

                    if($domain || $site){
                        $store = $domain ? Store::where('domain','LIKE','%'.$domain.'%') -> first() : Store::where('site',$site) -> first();
                        
                        if(!$store){
                            $store = new Store;

                            if($domain){
                                $store -> domain = $domain;
                            }

                            if($site){
                                $store -> site = $site;
                            }
                        }

                        $store -> apiUpdate();
                        $store -> apiFeedUpdate();
                        $store -> apiProductListUpdate();

                        if($posts){
                            $store -> apiPostsUpdate(true);
                            $this->info($store -> name.' - Store Posts Updated!');
                        }

                        $this->info($store -> name.' - Store Updated!');
                    }
                }else{
                    
                }
            }
        }

        $this->info('Stores Update Completed!');
    }
}
