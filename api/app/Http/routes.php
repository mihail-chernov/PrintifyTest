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

$_SERVER['HTTP_HOST'] = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';
        
if (strpos($_SERVER['HTTP_HOST'], 'errors.') === false and isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false) {
    $prefix_public = '/api';
} else {
    $prefix_public = '';
}


Route::get('/', function () {
    return view('welcome');
});

Route::get($prefix_public.'/test', 'PrintifyController@test');
Route::post($prefix_public.'/addProduct', 'PrintifyController@addProduct');
Route::get($prefix_public.'/list','PrintifyController@listProducts');
Route::get($prefix_public.'/loadThumb','PrintifyController@showThumb');
Route::get($prefix_public.'/loadImage','PrintifyController@loadImage');
Route::get($prefix_public.'/loadImageInfo','PrintifyController@loadImageInfo');



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
