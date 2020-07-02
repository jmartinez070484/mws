<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->timestamps();
            $table->integer('active')->default(1);
            $table->integer('source_id');
            $table->boolean('specials')->default(1);
            $table->string('domain')->nullable();
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('fb_pixel')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('youtube')->nullable();
            $table->text('pinterest')->nullable();
            $table->longText('customer')->nullable();
            $table->longText('story')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
