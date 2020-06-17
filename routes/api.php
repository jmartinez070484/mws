<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/user','Api@user');
Route::post('/stores','Api@stores');
Route::post('/stores/{store}','Api@store') -> where('store','[0-9]+');
Route::post('/stores/{store}/feed','Api@feed') -> where('store','[0-9]+');
Route::post('/stores/{store}/products','Api@products') -> where('store','[0-9]+');
Route::post('/stores/{store}/posts','Api@blog_post') -> where('store','[0-9]+');
Route::post('/posts/{id}','Api@trivita_post') -> where('store','[0-9]+');