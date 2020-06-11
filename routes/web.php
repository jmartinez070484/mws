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
Route::get('/blog/{post}','Controller@post') -> name('post');
Route::get('/clinic','Controller@content') -> name('clinic');
Route::get('/policy','Controller@content') -> name('policy');
Route::get('/terms','Controller@content') -> name('terms');
Route::get('/contact','Controller@content') -> name('contact');
Route::get('/giving-back','Controller@content') -> name('giving');