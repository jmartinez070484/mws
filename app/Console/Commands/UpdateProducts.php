<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Product;
use App\Category;

class UpdateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update {--email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products via API.';

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
        $httpRequestCategories = Http::accept('application/json') -> get(env('TRIVITA_WELLNESS_API').'/api/Product');

        if($httpRequestCategories -> ok()){
            $categories = $httpRequestCategories -> json();

            foreach($categories as $categoryData){
                $category = Category::find($categoryData['ID']);

                if(!$category){
                    $category = new Category;
                    $category -> id = $categoryData['ID'];
                }

                $category -> name = Str::title($categoryData['Description']);
                $category -> slug = Str::slug($categoryData['Description']);
                $category -> save();

                $this->info($category -> name.' - Category Updated!');
            }

            $this->info('Categories Updated!');
        }

        $httpRequestCatalog = Http::accept('application/json') -> get(env('TRIVITA_API_CATALOG'));

        if($httpRequestCatalog -> ok()){
            $catalog = $httpRequestCatalog -> json();

            foreach($catalog as $item){
                $prodId = isset($item['ProdID']) ? $item['ProdID'] : null;

                if($prodId){
                    $product = Product::where('product_id',$prodId) -> limit(1) -> first();

                    if(!$product){
                        $product = new Product();
                        $product -> product_id = $prodId;
                    }

                    $product -> apiUpdate();
                    $product -> apiReviewsUpdate();

                    $this->info($product -> name ? 'Product - '.$product -> name : 'Failed - '.$prodId);
                }
            }
        }

        $this->info('Products Updated!');
    }
}
