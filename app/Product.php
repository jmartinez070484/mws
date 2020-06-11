<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Review;

class Product extends Model
{
    protected $table = 'products';

    /*

        Reviews

    */
    public function reviews(){
        return $this->hasMany(Review::class,'product_id','product_id') -> orderBy('created_at','DESC');
    }

    /*

        API Reviews Update

    */
    public function apiReviewsUpdate(){
        if($this -> product_id && $this -> slug){
            $reviewsApiUrl = Str::replaceArray('{id}',[$this -> product_id],env('TRIVITA_API_PRODUCT_REVIEWS'));
            $httpRequestReviews = Http::get($reviewsApiUrl);

            if($httpRequestReviews -> ok()){
                $reviewData = $httpRequestReviews -> json();
                $reviews = isset($reviewData['List']) ? $reviewData['List'] : [];

                foreach($reviews as $key => $singleReview){
                    if($singleReview['Text'] && $singleReview['CustFName'] && $singleReview['CustLInitial']){
                        $review = Review::where('id',$singleReview['ID']) -> first();

                        if(!$review){
                            $review = new Review;
                            $review -> id = $singleReview['ID'];
                            $review -> product_id = $this -> product_id;
                            $review -> created_at = $singleReview['CreateDate'];
                        }

                        $review -> score = $singleReview['Rank'];
                        $review -> name = $singleReview['CustFName'].' '.$singleReview['CustLInitial'];
                        $review -> content = $singleReview['Text'];
                        $review -> save();
                    }
                }

                $this -> review_score = $reviewData['Rounded'];
                $this -> review_total = $reviewData['Count'];
                $this -> save();
            }
        }
    }

    /*

		API Update

    */
    public function apiUpdate(){
    	if($this -> product_id){
    		$productApiUrl = Str::replaceArray('{id}',[$this -> product_id],env('TRIVITA_API_PRODUCT'));
            $httpRequestProduct = Http::get($productApiUrl);

            if($httpRequestProduct -> ok()){
                $productData = $httpRequestProduct -> json();

                if($productData['Slug']){
                	$this -> name = $productData['ProductName'];
                    $this -> slug = $productData['Slug'];
                    $this -> claim = $productData['Claim'];
                    $this -> details = $productData['ProductDetails'];
                    $this -> short_description = $productData['ShortDescription'];
                    $this -> long_description = $productData['LongDescription'];
                    $this -> package = $productData['PackageContent'];
                    $this -> serving = $productData['ServingSize'];
                    $this -> retail_price = $productData['RetailPrice'];
                    $this -> net_price = $productData['NetPrice'];
                    $this -> stock = !$productData['OutOfStock'];
                    $this -> discounts = $productData['Discounts'] ? json_encode($productData['Discounts']) : null;
                    $this -> seals = $productData['ProductSeals'] ? json_encode($productData['ProductSeals']) : null;
                    $this -> systems = $productData['BodySystems'] ? json_encode($productData['BodySystems']) : null;
                    $this -> categories = $productData['HealthCategories'] ? json_encode($productData['HealthCategories']) : null;
                    $this -> cross_sell = $productData['CrossSellProducts'] ? json_encode($productData['CrossSellProducts']) : null;
                    $this -> equivalents = $productData['Equivalents'] ? json_encode($productData['Equivalents']) : null;
                    $this -> faq = $productData['FAQ'] ? json_encode($productData['FAQ']) : null;
                    $this -> popular = $productData['Popular'] ? json_encode($productData['Popular']) : null;
                    $this -> references = $productData['References'] ? json_encode($productData['References']) : null;
                    $this -> save();
                }
            }
    	}
	}

    /*

		Slug

    */
    public function getRouteKeyName(){
    	return 'slug';
	}
}
