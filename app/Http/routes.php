<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/photo','PhotoController@index');
Route::get('/content','PhotoController@content');
Route::get('/chengtu','ActivityController@chengtu');
Route::get('/jiegou','ActivityController@jiegou');
Route::get('/bimsoft','ActivityController@bimsoft');
Route::get('/bimgrass','ActivityController@bimgrass');
Route::get('/cadstill','ActivityController@cadstill');
Route::get('/building','ActivityController@building');
Route::get('/poker','ActivityController@poker');
Route::get('/bridge','ActivityController@bridge');
Route::get('/signin','AdminController@signin');
Route::get('/signup','AdminController@signup');
Route::post('/signin','AdminController@ysignin');