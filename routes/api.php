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

// medic
Route::post('medic/create', 'MedicController@create');
Route::post('medic/update', 'MedicController@update');
Route::get('medic/get/{id?}', 'MedicController@get');
Route::get('medic/delete/{id}', 'MedicController@delete');

// Examtype
Route::post('exam-type/create', 'ExamTypeController@create');
Route::post('exam-type/update', 'ExamTypeController@update');
Route::get('exam-type/get/{id?}', 'ExamTypeController@get');
Route::get('exam-type/delete/{id}', 'ExamTypeController@delete');

// offer
Route::post('offer/create', 'SendRequestController@create');
Route::post('offer/update', 'SendRequestController@update');
Route::get('offer/get/{id?}', 'SendRequestController@get');
Route::get('offer/delete/{id}', 'SendRequestController@delete');
Route::get('offer/respond/{id}/{response}', 'SendRequestController@respond');
Route::get('offer/pending/{id}', 'SendRequestController@getPendingOfferBYMedic');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
 //   return $request->user();
//});
