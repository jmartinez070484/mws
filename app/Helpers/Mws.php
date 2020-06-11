<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Store;

class Mws {

	private static $instance;
	public $store;
	public $feed;

	/*

		Object construct

	*/
	function __construct($request){
		$domain = $request -> getHttpHost();
		$store = Store::where('domain',$domain) -> first();
		
		if(!$store){
			$store = new Store;
			$store -> domain = $domain;
			$store -> apiUpdate();
		}
		
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