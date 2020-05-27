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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', 'UsuarioController@index');

//Route::post('/api/registrar','UsuarioController@registrar');
//Route::post('/api/login','UsuarioController@login');
//Route::resource('/api/cliente', 'ClienteController');


//Rutas que incluye todos los métodos HTTP
//Route::resource('/', 'UsuarioController');
Route::resource('/', 'UsuarioController');

Route::resource('/registro','UsuarioController');
Route::resource('/clientes','ClienteController');


