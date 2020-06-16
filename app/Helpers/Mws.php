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
			
			if(count($path) > 0){
				$domain = $path[0];
			}
		}

		$store = $mwsDefault ? Store::where('site',$domain) -> first() : Store::where('domain',$domain) -> first();
		
		if(!$store){
			$store = new Store;
			$store -> domain = $domain;
			
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