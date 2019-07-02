<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::group(['prefix' => 'v1' , 'namespace' => 'Api'],function(){
    Route::get('logs','MainController@logs');
    Route::get('governorates','MainController@governorates');
    Route::get('cities','MainController@cities');
    Route::get('categories','MainController@categories');
    Route::get('bloodTypes','MainController@bloodTypes');

    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('resetPassword','AuthController@resetPassword'); 
    Route::post('newPassword','AuthController@newPassword'); 


    Route::group(['middleware'=> 'auth:api'], function(){
        Route::get('posts','MainController@posts');    
        Route::get('post','MainController@post'); // not created yet 
        Route::get('my-favourite-posts','MainController@myFavouritePosts'); 
        Route::post('post-toggle-favourite','MainController@postFavourite'); // toggle favourites 
        // donationRequest = order 
        Route::get('orders','MainController@orders'); 
        Route::get('order','MainController@order'); 
        Route::post('order/create','MainController@orderCreate'); // not found page
         // notifications
        Route::get('notifications','MainController@notifications');  
        Route::get('notifications-count','MainController@notificationsCount');
        //Route::get('test-notification','MainController@testNotification');
        Route::post('notifications-settings','AuthController@notificationsSettings');

        Route::post('profile','AuthController@profile');
        Route::post('register-token','AuthController@registerToken'); 
        Route::post('remove-token','AuthController@removeToken');
        Route::get('contacts','MainController@contacts');
        Route::post('reports','MainController@reports');
        Route::get('settings','MainController@settings');
    });

});
