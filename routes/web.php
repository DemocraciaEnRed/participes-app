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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/bladeTest', 'HomeController@bladeTest')->name('bladeTest');

Route::group([
    'as' => 'panel.', 
    'prefix' => 'panel', 
    ],function () {
    Route::get('/', 'UserPanelController@index')->name('index');
    Route::get('/cambiar-acceso', 'UserPanelController@viewChangePassword')->name('password.change');
});

Route::group([
    'as' => 'admin.', 
    'prefix' => 'admin', 
    ],function () {
    Route::get('/', 'AdminPanelController@index')->name('index');
    // Categorias
    Route::get('/categorias', 'AdminPanelController@viewListCategories')->name('categories');
    Route::get('/categorias/nuevo', 'AdminPanelController@viewCreateCategory')->name('categories.create');
    Route::post('/categorias/nuevo', 'AdminPanelController@formCreateCategory')->name('categories.create.form');
    Route::get('/categorias/{id}/editar', 'AdminPanelController@viewEditCategory')->name('categories.edit');
    Route::put('/categorias/{id}/editar', 'AdminPanelController@formEditCategory')->name('categories.edit.form');
    // Organizaciones
    Route::get('/organizaciones', 'AdminPanelController@viewListOrganizations')->name('organizations');
    Route::get('/organizaciones/nuevo', 'AdminPanelController@viewCreateOrganization')->name('organizations.create');
    Route::post('/organizaciones/nuevo', 'AdminPanelController@formCreateOrganization')->name('organizations.create.form');
    Route::get('/organizaciones/{id}/editar', 'AdminPanelController@viewEditOrganization')->name('organizations.edit');
    Route::put('/organizaciones/{id}/editar', 'AdminPanelController@formEditOrganization')->name('organizations.edit.form');
    // Roles Usuarios
});