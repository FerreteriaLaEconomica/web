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

// Authentication Routes...
Route::get('login', 'CustomAuth\CustomAuthController@showLoginForm')->name('login');
Route::post('login', 'CustomAuth\CustomAuthController@login')->name('login');
Route::post('logout', 'CustomAuth\CustomAuthController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'CustomAuth\CustomRegistrationController@showRegistrationForm')
    ->name('register');
Route::post('register', 'CustomAuth\CustomRegistrationController@register')
    ->name('register');

Route::get('/home', 'HomeController@index')->name('home');
