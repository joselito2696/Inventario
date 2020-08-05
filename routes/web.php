<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['role:super-admin|moderador|editor']],function(){
    Route::resource('usuarios','UserController');
});
Route::post('login','Auth\LoginController@login')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('cliente','ClienteController@index' )->name('index');
Route::post('buscarCliente','ClienteController@buscar')->name('buscar');
Route::post('guardar', 'ClienteController@guardar')->name('guardar');
Route::get('listaSala','ClienteController@indexSala' )->name('indexSala');