<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
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
		
		if($store){
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

			return view('index',compact('mws','store','products'));
		}else{
			return view('landing');
		}
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
		
		return view('catalog',compact('mws','title','store','categories','products'));
	}

	/*

		Product

    */
	public function product(Product $product){
		return $this -> single_product($product);
	}

	/*

		Product

    */
	public function mws_product($site, Product $product){
		return $this -> single_product($product);
	}

	/*

		Single Product

	*/
	public function single_product(Product $product){
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
		
		return view('product',compact('mws','title','store','product','equivalents'));
	}

	/*

		Blog

    */
	public function blog(){
		$mws = Mws::instance();
		$store = $mws -> store;
		$title = 'Blog';

		return view('blog',compact('mws','title','store'));
	}

	/*

		Post

    */
	public function post(Request $request,$id){
		return $this -> single_post($id);
	}

	/*

		MWS post

    */
	public function mws_post($site, $id){
		return $this -> single_post($id);
	}

	/*

		Contact

    */
	public function contact(Request $request){
		$postData = $request->all();
		$response = ['success'=>false];

		//validate 
        $validator = Validator::make($postData,[
            'name' => ['required','string'],
            'email' => ['required','string','email'],
            'subject' => ['required','string'],
            'message' => ['required','string'],
        ]);

        if(!$validator -> fails()){
        	$response['success'] = true;
        }else{
        	$response['error'] = $validator -> errors() ->first();
        }

		return $response;
	}

	/* 


	*/
	public function single_post($id){
		$mws = Mws::instance();
		$store = $mws -> store;
		$recent = [];
		$post = Post::where('id',$id) -> where('store_id',$store -> id) -> first();

		if($post -> type === 2){
			$post = $post -> trivita_post;
		}
		
		if($post){
			$recentPosts = Post::where('store_id',$store -> id) -> where('id','!=',$id) -> orderBy('created_at','DESC') -> take(4) -> get();
			
			foreach($recentPosts as $recentPost){
				if($recentPost -> type === 2){
					$recentPostId = $recentPost -> id;
					$trivitaPost = $recentPost -> trivita_post;

					if($trivitaPost){
						$recentPost = $trivitaPost;
						$recentPost -> reference_id = $recentPostId;
					}
				}

				array_push($recent,$recentPost);
			}

			$title = $post -> name;

			return view('post',compact('mws','title','store','post','recent'));
		}else{
			abort(404);
		}
	}

	/*

		Content

    */
	public function content(Request $request){
		$element = Str::of($request->route()->getName()) -> replace('.','-');

		if(view() -> exists('partials.'.$element)){
			$mws = Mws::instance();
			$store = $mws -> store;

			return view('content',compact('mws','element','store'));
		}else{
			abort(404);
		}	
	}
}
