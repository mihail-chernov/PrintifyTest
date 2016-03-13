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
    $prefix_public = '/api/';
} else {
    $prefix_public = '';
}


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
