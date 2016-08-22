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

Route::get('/', 'SiteController@index');
Route::get('/delete/{id}', 'SiteController@delete');
Route::get('/view/{id}', 'SiteController@view');

Route::group(['prefix' => 'api',], function () {
    Route::get('/register', 'APIController@register');
});

Route::group(['prefix' => 'api', 'middleware'  => 'auth:api'], function () {
    Route::get('/send', 'APIController@sendEmail');
});



