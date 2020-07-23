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
    // Mis objetivos
    Route::get('/objetivos', 'UserPanelController@viewListObjectives')->name('objectives');
    // Mis suscripciones
    Route::get('/suscripciones', 'UserPanelController@viewListSubscriptions')->name('subscriptions');
    Route::post('/suscripciones/{objId}/desuscribir', 'UserPanelController@formUnsubSubscription')->name('subscriptions.unsubscribe.form');
    // Mis notificaciones
    Route::get('/notificaciones', 'UserPanelController@viewListNotifications')->name('notifications');
    Route::get('/notificaciones/pendientes', 'UserPanelController@viewListUnreadNotifications')->name('notifications.unread');
    Route::post('/notificaciones/pendientes/marcar', 'UserPanelController@formMarkAllUnreadNotifications')->name('notifications.mark.all.form');
    // Mi cuenta
    Route::get('/preferencias/avatar', 'UserPanelController@viewAccountAvatar')->name('account.avatar');
    Route::post('/preferencias/avatar', 'UserPanelController@formAccountAvatar')->name('account.avatar.form');
    Route::get('/preferencias/acceso', 'UserPanelController@viewAccountAccess')->name('account.access');
    Route::put('/preferencias/acceso', 'UserPanelController@formAccountAccess')->name('account.access.form');
    Route::get('/preferencias/email', 'UserPanelController@viewAccountEmail')->name('account.email');
    Route::put('/preferencias/email', 'UserPanelController@formAccountEmail')->name('account.email.form');
    Route::get('/preferencias/notificationes', 'UserPanelController@viewAccountNotifications')->name('account.notifications');
    Route::put('/preferencias/notificationes', 'UserPanelController@formAccountNotifications')->name('account.notifications.form');
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
    // Administradores
    Route::get('/administradores', 'AdminPanelController@viewListAdministrators')->name('administrators');
    Route::get('/administradores/nuevo', 'AdminPanelController@viewAddAdministrator')->name('administrators.add');
    Route::post('/administradores/nuevo', 'AdminPanelController@formAddAdministrator')->name('administrators.add.form');
    Route::delete('/administradores/{id}/eliminar', 'AdminPanelController@formDeleteAdministrator')->name('administrators.delete.form');
    // Objectives
    Route::get('/objetivos', 'AdminPanelController@viewListObjectives')->name('objectives');
    Route::get('/objetivos/nuevo', 'AdminPanelController@viewCreateObjectives')->name('objectives.create');
    Route::post('/objetivos/nuevo', 'AdminPanelController@formCreateObjectives')->name('objectives.create.form');
});

Route::group([
    'as' => 'apiService.', 
    'prefix' => 'api-service', 
    ],function () {
    // Userss
    Route::get('/users', 'UserController@fetch')->name('users');
    Route::get('/users/{id}', 'UserController@fetchOne')->name('users.fetch');
    Route::put('/notification/read', 'NotificationController@markAllRead')->name('notification.mark.all');
    Route::put('/notification/read/{id}', 'NotificationController@markOneRead')->name('notification.mark.one');
    Route::delete('/notification/clean', 'NotificationController@cleanAll')->name('notification.clean');


});

Route::group([
    'as' => 'objective.', 
    'prefix' => 'objetivo/{objId}', 
    ],function () {
    Route::get('/', 'ObjectiveController@index')->name('index');
    // Manage
    Route::group([
        'as' => 'manage.', 
        'prefix' => 'administrar', 
        ],function () {
        Route::get('/', 'ObjectivePanelController@index')->name('index');
        // Archivos
        Route::get('/suscriptores', 'ObjectivePanelController@viewListSubscribers')->name('subscribers');
        // Equipo
        Route::get('/equipo', 'ObjectivePanelController@viewListTeam')->name('team');
        Route::get('/equipo/agregar', 'ObjectivePanelController@viewAddTeam')->name('team.add');
        Route::post('/equipo/agregar', 'ObjectivePanelController@formAddTeam')->name('team.add.form');
        Route::post('/equipo/{usrId}/eliminar', 'ObjectivePanelController@formRemoveTeam')->name('team.remove.form');
        // Metas
        Route::get('/metas', 'ObjectivePanelController@viewListGoals')->name('goals');
        Route::get('/metas/nuevo', 'ObjectivePanelController@viewAddGoal')->name('goals.add');
        Route::post('/metas/nuevo', 'ObjectivePanelController@formAddGoal')->name('goals.add.form');
        Route::get('/metas/{goalId}', 'ObjectivePanelController@viewGoal')->name('goals.index');
        // Hitos
        Route::get('/metas/{goalId}/hitos', 'ObjectivePanelController@viewListGoalMilestones')->name('goals.milestones');
        Route::get('/metas/{goalId}/hitos/nuevo', 'ObjectivePanelController@viewAddGoalMilestone')->name('goals.milestones.add');
        Route::post('/metas/{goalId}/hitos/nuevo', 'ObjectivePanelController@formAddGoalMilestone')->name('goals.milestones.add.form');
        // Reporte
        Route::get('/metas/{goalId}/reportes', 'ObjectivePanelController@viewListGoalReports')->name('goals.reports');
        Route::get('/metas/{goalId}/reportes/nuevo', 'ObjectivePanelController@viewNewGoalReport')->name('goals.reports.add');
        Route::post('/metas/{goalId}/reportes/nuevo', 'ObjectivePanelController@formNewGoalReport')->name('goals.reports.add.form');
        Route::get('/metas/{goalId}/reportes/{reportId}', 'ObjectivePanelController@viewListGoalReports')->name('goals.reports.index');
        Route::get('/metas/{goalId}/reportes/{reportId}/album', 'ObjectivePanelController@viewAlbumReport')->name('goals.reports.album');
        // Administracion
        Route::get('/configuracion', 'ObjectivePanelController@viewObjectiveConfiguration')->name('configuration');
        Route::put('/configuracion', 'ObjectivePanelController@formObjectiveConfiguration')->name('configuration.form');
        Route::get('/portada', 'ObjectivePanelController@viewObjectiveCover')->name('cover');
        Route::post('/portada', 'ObjectivePanelController@formObjectiveCover')->name('cover.form');
        Route::get('/archivos', 'ObjectivePanelController@viewObjectiveFiles')->name('files');
        Route::post('/archivos', 'ObjectivePanelController@formObjectiveFile')->name('files.form');
        Route::get('/album', 'ObjectivePanelController@viewObjectiveAlbum')->name('album');
        Route::get('/mapa', 'ObjectivePanelController@viewObjectiveMap')->name('map');

    });

});

