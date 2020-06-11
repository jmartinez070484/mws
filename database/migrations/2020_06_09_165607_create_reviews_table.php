<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->timestamps();
            $table->integer('active')->default(1);
            $table->integer('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->float('score',8,2)->default(0);
            $table->text('name')->nullable();
            $table->longText('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
