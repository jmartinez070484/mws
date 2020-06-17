<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','Controller@index') -> name('index');
Route::get('/products','Controller@catalog') -> name('catalog');
Route::get('/products/{product}','Controller@product') -> name('product');
Route::get('/blog','Controller@blog') -> name('blog');
Route::get('/blog/{id}','Controller@post',['site' => null]) -> name('post');
Route::get('/clinic','Controller@content') -> name('clinic');
Route::get('/policy','Controller@content') -> name('policy');
Route::get('/terms','Controller@content') -> name('terms');
Route::get('/contact','Controller@content') -> name('contact');
Route::get('/giving-back','Controller@content') -> name('giving');

//mws domain
Route::get('/{site}','Controller@index') -> name('mws_index');
Route::get('/{site}/products','Controller@catalog') -> name('mws_catalog');
Route::get('/{site}/products/{product}','Controller@mws_product') -> name('mws_product');
Route::get('/{site}/blog','Controller@blog') -> name('mws_blog');
Route::get('/{site}/blog/{id}','Controller@mws_post') -> name('mws_post');
Route::get('/{site}/clinic','Controller@content') -> name('mws_clinic');
Route::get('/{site}/policy','Controller@content') -> name('mws_policy');
Route::get('/{site}/terms','Controller@content') -> name('mws_terms');
Route::get('/{site}/contact','Controller@content') -> name('mws_contact');
Route::get('/{site}/giving-back','Controller@content') -> name('mws_giving');