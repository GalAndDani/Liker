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

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@dashboard')->name('dashboard');
Auth::routes();

// Email Verification
Route::get('/verified', 'HomeController@verified')->name('verified.email');
Route::get('/verify-email/{token}', 'Auth\RegisterController@verify');

// Facebook API
Route::get('/login-fb', 'FacebookApi@index')->name('login-fb');
Route::get('/test', function () {
    return view('test');
});
