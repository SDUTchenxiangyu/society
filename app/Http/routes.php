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


Route::get('/','AdminController@welcome');
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
Route::post('/signup','AdminController@ysignup');
Route::get('/signout','AdminController@signout');
Route::get('/more','ActivityController@more');
Route::post('/baoming','ActivityController@baoming');
Route::get('/houtai','AdminController@houtai');
Route::post('/tamebaoming','ActivityController@tamebaoming');
Route::get('/self','AdminController@self');
Route::post('/self','AdminController@power');
Route::get('/dice','DiceController@index');
Route::post('/dice','DiceController@yanzheng');
Route::get('/dicechouqian','DiceController@cindex');
Route::post('/dicechouqian','DiceController@chouqian');
Route::get('/cadchouqian','ActivityController@cadchouqian');
Route::get('/file','ActivityController@file');
Route::post('/file','ActivityController@upload');