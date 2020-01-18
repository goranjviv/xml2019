<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichh
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group([
            'prefix' => 'user',
            'namespace' => 'User'
        ], function () {
            Route::post('change-password', 'UserController@changePassword');
            Route::post('/', 'UserController@updateProfile');
        });

        Route::group([
            'prefix' => 'articles',
        ], function () {
            Route::post('/', 'ArticleCoverLetter\ArticleCoverLetterController@store');
        });
    });

    Route::group([
        'prefix' => 'articles',
    ], function () {
        Route::get('/', 'ArticleCoverLetter\ArticleCoverLetterController@index');
    });
});
