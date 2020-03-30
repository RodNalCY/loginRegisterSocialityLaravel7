<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');


Route::get('socialauth/{provider}', 'Auth\GitHubSocialAuthController@redirectToProvider');

Route::get('socialauth/{provider}/callback', 'Auth\GitHubSocialAuthController@handleProviderCallback');


Route::get('/auth/redirect/{provider}', 'Auth\GoogleSocialAuthController@redirectToProvider')->name('login.provider');
Route::get('/callback/{provider}', 'Auth\GoogleSocialAuthController@handleProviderCallback')->name('login.callback');


Route::get('authfacebook/{provider}', 'Auth\FacebookSocialAuthController@redirectToProvider');
Route::get('authfacebook/{provider}/callback', 'Auth\FacebookSocialAuthController@handleProviderCallback');
