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

Route::get('/usuarios', 'UsuarioController@all');

Route::post('/usuario/store', 'UsuarioController@store');

Route::post('/usuario/{usuario}/update', 'UsuarioController@update');

Route::patch('/usuario/{usuario}/update/estado', 'UsuarioController@updateEstado');

