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
Route::get('/store/{store}','Api@store') -> where('store','[0-9]+');
Route::get('/store/{store}/feed','Api@feed') -> where('store','[0-9]+');
Route::get('/store/{store}/products','Api@products') -> where('store','[0-9]+');