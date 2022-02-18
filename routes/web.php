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

// Route::get('home', 'SocialController@inicio')->name('home');


/*Route::get('/home', function () {
    return view('home');
});*/

Route::get('/', 'UserController@listado');
// Route::get('/', 'home');

Auth::routes();

// PANEL DE CONTROL
Route::get('/home', 'PanelController@inicio');
Route::get('Panel/inicio', 'PanelController@inicio');

// RED SOCIAL
Route::get('Social/inicio', 'SocialController@inicio');

// USUARIOS
Route::get('User/listado', 'UserController@listado');
Route::get('User/nuevo', 'UserController@nuevo');
Route::post('User/ajaxDistrito', 'UserController@ajaxDistrito');
Route::post('User/ajaxOtb', 'UserController@ajaxOtb');
Route::post('User/guarda', 'UserController@guarda');
Route::get('User/ajax_listado', 'UserController@ajax_listado');
Route::get('User/edita/{id}', 'UserController@edita');
Route::get('User/elimina/{id}', 'UserController@elimina');
Route::get('User/pagos/{user_id}', 'UserController@pagos');
Route::get('User/cambiaPago/{id}/{estado}', 'UserController@cambiaPago');
Route::post('User/ajax_busca', 'UserController@ajax_busca');

// EVENTOS
Route::get('Evento/listado', 'EventoController@listado');
Route::get('Evento/ajax_listado', 'EventoController@ajax_listado');
Route::get('Evento/nuevo', 'EventoController@nuevo');
Route::get('Evento/nuevo', 'EventoController@nuevo');
Route::get('Evento/edita/{id}', 'EventoController@edita');
Route::post('Evento/guarda', 'EventoController@guarda');
Route::get('Evento/elimina/{id}', 'EventoController@elimina');
Route::get('Evento/asistencia/{id}', 'EventoController@asistencia');
Route::get('Evento/asiste/{user_id}/{evento_id}', 'EventoController@asiste');
Route::get('Evento/falta/{user_id}/{evento_id}', 'EventoController@falta');

//CATEGORIAS
Route::get('Categoria/listado', 'CategoriaController@listado');
Route::post('Categoria/guarda', 'CategoriaController@guarda');
Route::get('Categoria/elimina/{categoria_id}', 'CategoriaController@elimina');


