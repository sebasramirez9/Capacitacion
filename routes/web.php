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
    return view('content/content');
});

Route::get('/categoria','CategoriaController@index');
Route::post('/categoria/registrar','CategoriaController@store');
Route::put('/categoria/actualizar','CategoriaController@update');
Route::put('/categoria/activar','CategoriaController@on');
Route::put('/categoria/desactivar','CategoriaController@off');
Route::get('/categoria/selectCategoria','CategoriaController@selectCategory');


Route::get('/article','ArticuloController@index');
Route::post('/article/registrar','ArticuloController@store');
Route::put('/article/actualizar','ArticuloController@update');
Route::put('/article/activar','ArticuloController@on');
Route::put('/article/desactivar','ArticuloController@off');

Route::get('/client','ClienteController@index');
Route::post('/client/registrar','ClienteController@store');
Route::put('/client/actualizar','ClienteController@update');
