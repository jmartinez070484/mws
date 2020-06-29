<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Feed;
use App\ProductList;
use App\Post;

class Store extends Model
{
    protected $table = 'stores';

    /*

		Store products

    */
	public function products(){
		return $this->hasOne(ProductList::class,'store_id','id');
	}

    /*

		Store feed

    */
	public function feed(){
		return $this->hasMany(Feed::class,'store_id','id') -> orderBy('created_at','DESC');
	}

	/*

		Update posts via API

    */
    public function apiPostsUpdate($loop = null){
    	if($this -> id){
    		$page = 1;

    		if($loop){
    			Post::where('store_id',$this -> id) -> delete();
    			
    			while($page){
	    			$page = $loop ? $this -> postsUpdateLoops($page) : 0;
	    		}
    		}else{
    			$this -> postsUpdateLoops($page);
    		}
		}
    }

    /*

		Update posts via API

    */
    private function postsUpdateLoops($page){
    	$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store/'.$this -> id.'/Article/Blog/0/50/'.$page);

		if($httpRequest -> ok()){
			$response = $httpRequest -> json();
			
			if($response){
				$posts = isset($response['Result']) ? $response['Result'] : [];

				foreach($posts as $postData){
					$post = new Post;
					$post -> id = $postData['ID'];
					$post -> created_at = $postData['CreateDate'];
					$post -> type = isset($postData['WPBlogID']) ? 2 : 1;
					$post -> store_id = $this -> id;
					$post -> name = isset($postData['Title']) ? $postData['Title'] : null;
					$post -> content = $postData['Content'];
					$post -> image = isset($postData['Media'][0]['URL']) ? $postData['Media'][0]['URL'] : null;

					if($post -> type === 2){
						$post -> trivita_post_id = $postData['WPBlogID'];
					}

					$post -> save();
				}
			}
		}

		return isset($response['TotalPages']) && $page + 1 < $response['TotalPages'] ? $page + 1 : 0;
    }

	/*

		Update via API

    */
    public function apiProductListUpdate(){
    	if($this -> id){
    		$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Product/'.$this -> id);

			if($httpRequest -> ok()){
				$response = $httpRequest -> json();
				
				if($response){
					$productList = ProductList::where('store_id',$this -> id) -> first();

					if(!$productList){
						$productList = new ProductList;
						$productList -> store_id = $this -> id;
					}

					$productList -> content = json_encode($response);
					$productList -> save();
				}
			}
		}
    }

    /*

		Update via API

    */
    public function apiFeedUpdate(){
    	if($this -> id){
    		$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store/'.$this -> id.'/Article/Feed/0/50/1');

			if($httpRequest -> ok()){
				$response = $httpRequest -> json();
				$results = isset($response['Result']) ? $response['Result'] : [];

				Feed::where('store_id',$this -> id) -> delete();

				foreach($results as $result){
					$feed = new Feed;
					$feed -> reference = $result['ID'];
					$feed -> created_at = $result['CreateDate'];
					$feed -> active = $result['Active'];
					$feed -> store_id = $this -> id;
					$feed -> content = $result['Content'];
					$feed -> image = isset($result['Media'][0]['URL']) ? $result['Media'][0]['URL'] : null;
					$feed -> save();
				}
			}
		}
    }

    /*

		Update via API

    */
    public function apiUpdate(){
    	if($this -> domain){
    		$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store/Search/?domainOrAddress='.$this -> domain);
    		
			if($httpRequest -> ok()){
				$response = $httpRequest -> json();
				$validSocialMedia = ['facebook','instagram','youtube','pinterest'];
				$socialMedia = isset($response['Settings']['Social']) ? $response['Settings']['Social'] : null;
				
				$this -> id = $response['ID'];
				$this -> active = $response['Active'];
				$this -> source_id = $response['SourceID'];
				$this -> specials = isset($response['Settings']['DisplaySpecials']) ? $response['Settings']['DisplaySpecials'] : 0;
				$this -> domain = $response['Settings']['Domain'];
				$this -> site = $response['Settings']['SiteAddress'];
				$this -> name = $response['Settings']['Title'];
				$this -> color = $response['Settings']['Color'];
				$this -> fb_pixel = isset($response['Settings']['FBPixel']) ? isset($response['Settings']['FBPixel']) : null;
				$this -> customer = $response['Customer'] ? json_encode($response['Customer']) : null;
				$this -> story = isset($response['Settings']['Story']) ? $response['Settings']['Story'] : null;
				
				foreach($socialMedia as $socialMediaItem){
					$socialMediaName = Str::slug($socialMediaItem['Type']['Description'],'');
					
					$this -> $socialMediaName = in_array($socialMediaName,$validSocialMedia) && $socialMediaItem['URL'] ? $socialMediaItem['URL'] : null;
				};

				$mediaId = isset($response['Settings']['MediaID']) ? $response['Settings']['MediaID'] : null;
				
				if($mediaId){
					$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Media/'.$mediaId);

					if($httpRequest -> ok()){
						$response = $httpRequest -> json();
						$mediaUrl = isset($response['URL']) ? $response['URL'] : null;
						
						if($mediaUrl){
							$this -> media = $mediaUrl;
						}
					}
				}

				$this -> save();
			}
    	}
    }

}
