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
use App\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function(){

	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');

	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

	Route::get('/', 'AdminController@index')->name('admin.index');

	Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

	// Password reset routes
	Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

	Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

	Route::post('password/reset', 'Auth\AdminResetPasswordController@reset');

	Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

});



Route::resource('teams', 'TeamController');

Route::resource('teams/{team}/posts', 'PostController',['except' => ['index','show','create']]);

Route::resource('teams/{team}/members', 'MembersController',['except' => ['index','show','create','edit']]);

Route::resource('teams/{team}/games', 'GameController', ['except' => ['index','show']]);

Route::resource('teams/{team}/games/{game}/player', 'PlayerController', ['only' => ['store','destroy']]);

Route::get('api/get-city-list','APIController@getCityList');



