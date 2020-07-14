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
// auth
Route::post('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');

//users
Route::post('user/create', 'UserController@create');
Route::post('user/update', 'UserController@update');
Route::get('user/get/{id?}', 'UserController@get');
Route::get('user/delete/{id}', 'UserController@delete');
Route::post('user/change-password', 'UserController@changePassword');

//vendor
Route::post('vendor/create', 'VendorController@create');
Route::post('vendor/update', 'VendorController@update');
Route::get('vendor/get/{id?}', 'VendorController@get');
Route::get('vendor/delete/{id}', 'VendorController@delete');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
 //   return $request->user();
//});
