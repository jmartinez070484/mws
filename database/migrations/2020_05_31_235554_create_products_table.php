<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('active')->default(1);
            $table->integer('product_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('claim')->nullable();
            $table->text('details')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->longText('long_description')->nullable();  
            $table->string('package')->nullable();
            $table->string('serving')->nullable();
            $table->float('retail_price',8,2);
            $table->float('net_price',8,2);
            $table->boolean('stock')->default(1);
            $table->float('review_score',8,2)->default(0);
            $table->float('review_total',8,2)->default(0);    
            $table->longText('discounts')->nullable();
            $table->longText('seals')->nullable(); 
            $table->longText('systems')->nullable();
            $table->longText('categories')->nullable();
            $table->longText('cross_sell')->nullable();
            $table->longText('equivalents')->nullable();
            $table->longText('faq')->nullable();
            $table->longText('references')->nullable();
            $table->longText('popular')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
