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


Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user'); //todo: удалить
        Route::post('logout', 'AuthController@logout');
    });
});

Route::get('lists/{id}', 'ListsController@show');

/* product */
Route::delete('product/delete', 'ProductController@destroyMany');
Route::resource('product', 'ProductController', ['only' => [
    'store', 'update', 'destroy'
]]);

Route::group(['middleware' => 'auth:api'], function () {

    /* user */
    Route::get('user/search', 'UserController@userSearch');
    Route::put('user/collaboration', 'UserController@collaborationAdd');
    Route::delete('user/collaboration', 'UserController@collaborationDel');

    /* lists */
    Route::post('lists/discount-card', 'ListsController@addDiscountCard');
    Route::delete('lists/discount-card', 'ListsController@delDiscountCard');
    Route::resource('lists', 'ListsController', ['only' => [
        'index', 'show', 'store', 'update', 'destroy'
    ]]);

    /* discount card */
    Route::get('discount-card/brands', 'DiscountCardController@getDiscountCardBrands');
    Route::resource('discount-card', 'DiscountCardController', ['only' => [
        'index', 'store', 'update', 'destroy'
    ]]);
});

