<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Helpers\Mws;
use App\Product;
use App\Category;
use App\Post;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*

		Construct

    */
    public function __construct()
    {
        $this->middleware('check.domain');
    }

    /*

		Index

    */
	public function index(){
		$mws = Mws::instance();
		$store = $mws -> store;
		
		try{
			$productList = $store -> products ? json_decode($store -> products -> content) : [];
		}catch(Exception $exception){
			$productList = [];
		}
		
		$products = [];
		
		foreach($productList as $productItem){
			$product = Product::where('product_id',$productItem -> Product -> ID) -> first();

			if($product){
				array_push($products,$product);

				if(count($products) > 3){
					break;
				}
			}
		}

		return view('index',compact('store','products'));
	}

	/*

		Catalog

    */
	public function catalog(){
		$mws = Mws::instance();
		$store = $mws -> store;
		$categories = Category::all();

		try{
			$productList = $store -> products ? json_decode($store -> products -> content) : [];
		}catch(Exception $exception){
			$productList = [];
		}
		
		$products = [];
		
		foreach($productList as $productItem){
			$product = Product::where('product_id',$productItem -> Product -> ID) -> first();

			if($product){
				$product -> category = $productItem -> Category -> ID;
				array_push($products,$product);
			}
		}

		$title = 'Products';
		
		return view('catalog',compact('title','store','categories','products'));
	}

	/*

		Product

    */
	public function product(Product $product){
		$mws = Mws::instance();
		$store = $mws -> store;
		$keys = ['seals','categories','cross_sell','faq','popular','equivalents','references'];
		$equivalents = [];

		foreach($keys as $key){
			if(isset($product -> $key)){
				try{
					$product -> $key = json_decode($product -> $key);
				}catch(Exception $exception){
					$product -> $key = [];
				}
			}
		}
		
		$title = $product -> name;

		if(!is_array($product -> equivalents)){
			$product -> equivalents = [];
		}

		if(count($product -> equivalents) > 0){
			array_push($equivalents,$product);
		}

		foreach($product -> equivalents as $equivalent){
			$equivalentProduct = Product::where('product_id',$equivalent -> ProdID) -> first();

			if($equivalentProduct){
				array_push($equivalents,$equivalentProduct);
			}
		}

		return view('product',compact('title','store','product','equivalents'));
	}

	/*

		Blog

    */
	public function blog(){
		$mws = Mws::instance();
		$store = $mws -> store;
		$title = 'blog';

		return view('blog',compact('title','store'));
	}

	/*

		Post

    */
	public function post(Request $request,Post $post){
		$mws = Mws::instance();
		$store = $mws -> store;
		$recent = Post::where('active',1) -> where('post_id','!=',$post -> post_id) -> orderBy('created_at','desc') -> take(4) -> get();
		$title = $post -> name;
		
		return view('post',compact('title','store','post','recent'));
	}

	/*

		Content

    */
	public function content(Request $request){
		$element = Str::of($request->route()->getName()) -> replace('.','-');

		if(view() -> exists('partials.'.$element)){
			$mws = Mws::instance();
			$store = $mws -> store;

			return view('content',compact('element','store'));
		}else{
			abort(404);
		}	
	}
}
