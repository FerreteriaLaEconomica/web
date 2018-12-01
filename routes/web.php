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

Route::get('home', 'HomeController@index')->name('index');

Route::get('sucursal/{idSucursal}',[
	'uses'=> 'HomeController@showById'
])->name('home');

Route::get('sucursal/{idSucursal}/producto/{idProducto}',[
	'as'=>'producto-detalles',
	'uses'=>'HomeController@showProduct'
]);

Route::get('carritoShow/agregar/{idSucursal}/{idProducto}',[
    'as'=>'carrito-agregar',
    'uses'=>'CarritoController@add'
]);

Route::get('carritoShow/',[
    'as'=>'carrito',
    'uses'=>'CarritoController@show'
]);

Route::get('carrito/actualizar/{id}/{cantidad?}',[
    'as'=>'carrito-actualizar',
    'uses'=>'CarritoController@update'
]);

Route::get('carritoShow/borrar/{id}',[
    'as'=>'carrito-borrar',
    'uses'=>'CarritoController@remove'
]);

Route::get('eliminarTodo/',[
    'as'=>'carrito-vaciar',
    'uses'=>'CarritoController@removeAll'
]);

Route::get('orden-detalle',[
    'middleware'=>'custom.auth',
    'as'=>'orden-detalle',
    'uses'=>'CarritoController@ordenDetalle'
]);
