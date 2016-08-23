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

Route::get('/', 'EmailController@index');
Route::get('/delete/{id}', 'EmailController@delete');
Route::get('/view/{id}', 'EmailController@view');
Route::get('/test', 'EmailController@test');

Route::group(['prefix' => 'api',], function () {
    Route::get('/register', 'APIController@register');
});

Route::group(['prefix' => 'api', 'middleware'  => 'auth:api'], function () {
    Route::get('/send', 'APIController@sendEmail');
});



