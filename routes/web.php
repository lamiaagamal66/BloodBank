<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware'=>['auth', 'auto-check-permission'] , 'perfix' =>'admin'] ,function(){

Route::get('/home', 'HomeController@index')->name('home'); 

Route::resource('client', 'ClientController');
// Route::post('client/search', 'ClientController@search')->name('client.search');
Route::get('client-activate/{id}', 'ClientController@activate')->name('client.activate');
Route::get('client-deactivate/{id}', 'ClientController@deactivate')->name('client.deactivate');
// Route::get('client-toggleActivation/{id}', 'ClientController@toggleActivation')->name('client.toggleActivation');/

Route::resource('governorate', 'GovernorateController');
Route::resource('city', 'CityController');
Route::resource('category', 'CategoryController');
Route::resource('bloodType', 'BloodTypeContro   ller');

Route::resource('contact', 'ContactController');
Route::post('contact/search','ContactController@search')->name('contact.search');

Route::resource('order', 'OrderController');
Route::post('order/search', 'OrderController@search')->name('order.search');

Route::resource('post', 'PostController');
Route::resource('setting', 'SettingController');
Route::resource('role', 'RoleController');

Route::resource('user', 'UserController');
Route::get('change-password', 'UserController@changePassword')->name('user.changePassword');
Route::post('change-password', 'UserController@changePasswordSave');
Route::get('logout', 'UserController@logout')->name('user.logout');

});
