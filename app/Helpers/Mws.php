<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Store;

class Mws {

	private static $instance;
	public $default;
	public $store;
	public $feed;

	/*

		Object construct

	*/
	function __construct(Request $request){
		$domain = $request -> getHttpHost();
		$mwsDefault = $domain === env('APP_DEFAULT_DOMAIN') ? true : false;

		if($mwsDefault && !$request -> is('/')){
			$path = explode('/',$request -> path());
			$site = count($path) > 0 ? $path[0] : null;
		}

		$store = $mwsDefault ? Store::where('site',$site) -> first() : Store::where('domain',$domain) -> first();
		
		if(!$store){
			$store = new Store;

			if($domain){
				$store -> domain = $domain;
			}

			if($site){
				$store -> site = $site;
			}

			$store -> save();
			
			if(!$mwsDefault){
				$store -> apiUpdate();
			}
		}	
		
		$this -> default = $mwsDefault;
		$this -> store = $store -> id ? $store : null;
	}

	/*

        Return object instance

    */
    public static function instance(Request $request = null){
        if(!(self::$instance instanceof self)){
            self::$instance = new self($request);
        }

        return self::$instance;
    }
}