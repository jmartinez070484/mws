<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Feed;
use App\ProductList;

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
    		$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store/'.$this -> id.'/Article/Feed/1/10/1');

			if($httpRequest -> ok()){
				$response = $httpRequest -> json();
				$results = isset($response['Result']) ? $response['Result'] : [];

				foreach($results as $result){
					$feed = Feed::where('reference',$result['ID']) -> first();

					if(!$feed){
						$feed = new Feed;
						$feed -> reference = $result['ID'];
					}
					
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
				$this -> name = $response['Settings']['Title'];
				$this -> color = $response['Settings']['Color'];
				$this -> fb_pixel = isset($response['Settings']['FBPixel']) ? isset($response['Settings']['FBPixel']) : null;
				$this -> customer = $response['Customer'] ? json_encode($response['Customer']) : null;

				foreach($socialMedia as $socialMediaItem){
					$socialMediaName = strtolower($socialMediaItem['Type']['Description']);

					if(in_array($socialMediaName,$validSocialMedia)){
						$this -> $socialMediaName = $socialMediaItem['URL'];
					}
				}

				$httpRequest = Http::get(env('TRIVITA_WELLNESS_API').'/api/Store/'.$response['ID'].'/Article/Story/1/1/1');

				if($httpRequest -> ok()){
					$response = $httpRequest -> json();
					$story = isset($response['Result'][0]['Content']) ? $response['Result'][0]['Content'] : null;

					if($story){
						$this -> story = $story;
					}
				}

				$this -> save();
			}
    	}
    }

}
