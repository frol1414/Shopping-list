<?php

use Illuminate\Support\Facades\Route;

Route::post('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/callback/{provider}', 'Auth\LoginController@handleProviderCallback')->where('provider', '.*');
Route::get('/list/s/{slug}', 'MainController@showList');
//Route::get('login/callback/{provider}', 'Auth\LoginController@handleProviderCallback');
Route::get('/{any}', 'MainController@index')->where('any', '^(?!api\/)[\/\w\.-]*');
