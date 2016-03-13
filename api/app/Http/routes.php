<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'PrintifyController@test');
Route::post('/addProduct', 'PrintifyController@addProduct');
Route::get('/list','PrintifyController@listProducts');
Route::get('/loadThumb','PrintifyController@showThumb');
Route::get('/loadImage','PrintifyController@loadImage');
Route::get('/loadImageInfo','PrintifyController@loadImageInfo');



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
