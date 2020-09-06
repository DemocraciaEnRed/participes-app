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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/start', 'MiscController@start')->name('start');
Route::post('/start', 'MiscController@startApp')->name('start.form');
Route::get('/testmail', 'MiscController@testEmail')->name('misc.testEmail');

Route::group([
    'as' => 'about.', 
    'prefix' => 'acerca', 
    ],function () {
    Route::get('/general', 'HomeController@viewAboutGeneral')->name('general');
    Route::get('/faq', 'HomeController@viewAboutQuestions')->name('faq');
    Route::get('/legales', 'HomeController@viewAboutLegals')->name('legal');
});

Route::group([
    'as' => 'aboutTwo.', 
    'prefix' => 'acerca2', 
    ],function () {
    Route::get('/general', 'HomeController@viewAboutGeneralTwo')->name('general');
    Route::get('/faq', 'HomeController@viewAboutQuestionsTwo')->name('faq');
    Route::get('/legales', 'HomeController@viewAboutLegalsTwo')->name('legal');
});

Route::group([
    'as' => 'events.', 
    'prefix' => 'eventos', 
    ],function () {
    Route::get('/', 'EventController@showUpcomingEvents')->name('upcoming');
    Route::get('/pasados', 'EventController@showPastEvents')->name('past');
    Route::get('/{eventId}', 'EventController@index')->name('index');
});

Auth::routes(['verify' => true]);

Route::group([
    'as' => 'panel.', 
    'prefix' => 'panel', 
    ],function () {
    Route::get('/', 'UserPanelController@index')->name('index');
    // Mis objetivos
    Route::get('/objetivos', 'UserPanelController@viewListObjectives')->name('objectives');
    // Mis suscripciones
    Route::get('/suscripciones', 'UserPanelController@viewListSubscriptions')->name('subscriptions');
    Route::post('/suscripciones/{objectiveId}/desuscribir', 'UserPanelController@formUnsubSubscription')->name('subscriptions.unsubscribe.form');
    // Mis notificaciones
    Route::get('/notificaciones', 'UserPanelController@viewListNotifications')->name('notifications');
    Route::get('/notificaciones/pendientes', 'UserPanelController@viewListUnreadNotifications')->name('notifications.unread');
    Route::post('/notificaciones/pendientes/marcar', 'UserPanelController@formMarkAllUnreadNotifications')->name('notifications.mark.all.form');
    Route::post('/notificaciones/eliminar', 'UserPanelController@formDeleteAllNotifications')->name('notifications.delete.all.form');
    // Mi cuenta
    Route::get('/preferencias/verificar', 'UserPanelController@viewVerifyAccount')->name('account.verify');
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
    Route::get('/bitacora', 'AdminPanelController@viewLogs')->name('logs');
    // Categorias
    Route::get('/categorias', 'AdminPanelController@viewListCategories')->name('categories');
    Route::get('/categorias/nuevo', 'AdminPanelController@viewCreateCategory')->name('categories.create');
    Route::post('/categorias/nuevo', 'AdminPanelController@formCreateCategory')->name('categories.create.form');
    Route::get('/categorias/{categoryId}/editar', 'AdminPanelController@viewEditCategory')->name('categories.edit');
    Route::put('/categorias/{categoryId}/editar', 'AdminPanelController@formEditCategory')->name('categories.edit.form');
    Route::get('/categorias/{categoryId}/eliminar', 'AdminPanelController@viewDeleteCategory')->name('categories.delete');
    Route::delete('/categorias/{categoryId}/eliminar', 'AdminPanelController@formDeleteCategory')->name('categories.delete.form');
    // Organizaciones
    Route::get('/organizaciones', 'AdminPanelController@viewListOrganizations')->name('organizations');
    Route::get('/organizaciones/nuevo', 'AdminPanelController@viewCreateOrganization')->name('organizations.create');
    Route::post('/organizaciones/nuevo', 'AdminPanelController@formCreateOrganization')->name('organizations.create.form');
    Route::get('/organizaciones/{organizationId}/editar', 'AdminPanelController@viewEditOrganization')->name('organizations.edit');
    Route::put('/organizaciones/{organizationId}/editar', 'AdminPanelController@formEditOrganization')->name('organizations.edit.form');
    Route::get('/organizaciones/{organizationId}/eliminar', 'AdminPanelController@viewDeleteOrganization')->name('organizations.delete');
    Route::delete('/organizaciones/{organizationId}/eliminar', 'AdminPanelController@formDeleteOrganization')->name('organizations.delete.form');
    // Administradores
    Route::get('/administradores', 'AdminPanelController@viewListAdministrators')->name('administrators');
    Route::get('/administradores/nuevo', 'AdminPanelController@viewAddAdministrator')->name('administrators.add');
    Route::post('/administradores/nuevo', 'AdminPanelController@formAddAdministrator')->name('administrators.add.form');
    Route::delete('/administradores/{adminId}/eliminar', 'AdminPanelController@formDeleteAdministrator')->name('administrators.delete.form');
    // Objectives
    Route::get('/objetivos', 'AdminPanelController@viewListObjectives')->name('objectives');
    Route::get('/objetivos/descargar', 'AdminPanelController@downloadListObjectives')->name('objectives.download');
    Route::get('/objetivos/nuevo', 'AdminPanelController@viewCreateObjective')->name('objectives.create');
    Route::post('/objetivos/nuevo', 'AdminPanelController@formCreateObjective')->name('objectives.create.form');
    // Events
    Route::get('/eventos', 'AdminPanelController@viewUpcomingEvents')->name('events');
    Route::get('/eventos/pasados', 'AdminPanelController@viewPastEvents')->name('events.past');
    Route::get('/eventos/nuevo', 'AdminPanelController@viewCreateEvent')->name('events.create');
    Route::post('/eventos/nuevo', 'AdminPanelController@formCreateEvent')->name('events.create.form');
    Route::get('/eventos/{eventId}/editar', 'AdminPanelController@viewEditEvent')->name('events.edit');
    Route::put('/eventos/{eventId}/editar', 'AdminPanelController@formEditEvent')->name('events.edit.form');
    Route::post('/eventos/{eventId}/fotos/agregar', 'AdminPanelController@formAddPictureEvent')->name('events.pictures.add');
    Route::delete('/eventos/{eventId}/fotos/{pictureId}/eliminar', 'AdminPanelController@formDeletePictureEvent')->name('events.pictures.delete');
    Route::get('/eventos/{eventId}/eliminar', 'AdminPanelController@viewDeleteEvent')->name('events.delete');
    Route::delete('/eventos/{eventId}/eliminar', 'AdminPanelController@formDeleteEvent')->name('events.delete.form');
});

Route::group([
    'as' => 'apiService.', 
    'prefix' => 'api-service', 
    ],function () {
    // Userss
    Route::get('/home/stats', 'HomeController@fetchStats')->name('home.stats');
    Route::get('/users', 'UserController@fetch')->name('users');
    Route::get('/users/avatar', 'UserController@fetchAvatar')->name('users.avatar');
    Route::get('/users/{id}', 'UserController@fetchOne')->name('users.fetch');
    Route::put('/notification/read', 'NotificationController@markAllRead')->name('notification.mark.all');
    Route::put('/notification/read/{id}', 'NotificationController@markOneRead')->name('notification.mark.one');
    Route::delete('/notification/clean', 'NotificationController@cleanAll')->name('notification.clean');
    Route::get('/reports', 'ReportController@fetch')->name('reports');
    Route::get('/reports/{reportId}/comments', 'ReportController@fetchComments')->name('reports.comments');
    Route::post('/reports/{reportId}/comments', 'ReportController@runCreateComment')->name('reports.comments.create');
    Route::put('/reports/{reportId}/comments/{commentId}/edit', 'ReportController@runEditComment')->name('reports.comments.edit');
    Route::post('/reports/{reportId}/comments/{commentId}/reply', 'ReportController@runCreateReply')->name('reports.comments.reply');
    Route::delete('/reports/{reportId}/comments/{commentId}/delete', 'ReportController@runDeleteComment')->name('reports.comments.delete');
    Route::put('/reports/{reportId}/comments/{commentId}/reply/{replyId}/edit', 'ReportController@runEditReply')->name('reports.comments.reply.edit');
    Route::delete('/reports/{reportId}/comments/{commentId}/reply/{replyId}/delete', 'ReportController@runDeleteReply')->name('reports.comments.reply.delete');
    Route::post('/reports/{reportId}/testimony', 'ReportController@runToggleTestimony')->name('reports.testimonies.run');
    Route::get('/objectives', 'ObjectiveController@fetch')->name('objectives');
    Route::get('/objectives/{objectiveId}', 'ObjectiveController@fetchOne')->name('objectives.fetch');
    Route::get('/objectives/{objectiveId}/reports', 'ObjectiveController@fetchReports')->name('objectives.reports');
    Route::get('/objectives/{objectiveId}/stats', 'ObjectiveController@fetchStats')->name('objectives.stats');
    Route::get('/goal/{goalId}/reports', 'GoalController@fetchReports')->name('goals.reports');



});

Route::get('/objetivos', 'ObjectiveController@viewList')->name('objectives');
Route::post('/objetivos/{objectiveId}/subscribirse', 'ObjectiveController@formToggleSubscription')->name('objectives.subscribers.form');
Route::get('/reportes', 'ReportController@viewList')->name('reports');
Route::get('/reportes/{reportId}', 'ReportController@index')->name('reports.index');
Route::post('/reportes/{reportId}/testimony', 'ReportController@formToggleTestimony')->name('reports.testimonies.form');
Route::get('/metas/{goalId}', 'GoalController@index')->name('goals.index');

Route::group([
    'as' => 'objectives.', 
    'prefix' => 'objetivos', 
    ],function () {
    Route::get('/{objectiveId}', 'ObjectiveController@index')->name('index');
    // Manage
    Route::group([
        'as' => 'manage.', 
        'prefix' => '/{objectiveId}/administrar', 
        ],function () {
        Route::get('/', 'ObjectivePanelController@index')->name('index');
        Route::get('/editar', 'ObjectivePanelController@viewEditObjective')->name('edit');
        Route::put('/editar', 'ObjectivePanelController@formEditObjective')->name('edit.form');
        // Administracion
        Route::get('/logs', 'ObjectivePanelController@viewObjectiveLogs')->name('logs');
        Route::get('/configuracion', 'ObjectivePanelController@viewObjectiveConfiguration')->name('configuration');
        Route::put('/configuracion/ocultar', 'ObjectivePanelController@formObjectiveConfigurationHide')->name('configuration.hide.form');
        Route::put('/configuracion/mapa', 'ObjectivePanelController@formObjectiveConfigurationMap')->name('configuration.map.form');
        Route::get('/portada', 'ObjectivePanelController@viewObjectiveCover')->name('cover');
        Route::post('/portada', 'ObjectivePanelController@formObjectiveCover')->name('cover.form');
        Route::get('/archivos', 'ObjectivePanelController@viewObjectiveFiles')->name('files');
        Route::post('/archivos', 'ObjectivePanelController@formObjectiveFile')->name('files.form');
        Route::get('/mapa', 'ObjectivePanelController@viewObjectiveMap')->name('map');
        Route::delete('/eliminar', 'ObjectivePanelController@formDeleteObjective')->name('delete.form');
        // Suscriptores
        Route::get('/suscriptores', 'ObjectivePanelController@viewListSubscribers')->name('subscribers');
        Route::get('/suscriptores/descargar', 'ObjectivePanelController@downloadListSubscribers')->name('subscribers.download');
        // Equipo
        Route::get('/equipo', 'ObjectivePanelController@viewListTeam')->name('team');
        Route::get('/equipo/agregar', 'ObjectivePanelController@viewAddTeam')->name('team.add');
        Route::post('/equipo/agregar', 'ObjectivePanelController@formAddTeam')->name('team.add.form');
        Route::delete('/equipo/{usrId}/eliminar', 'ObjectivePanelController@formRemoveTeam')->name('team.remove.form');
        // Equipo
        Route::get('/comunidades', 'ObjectivePanelController@viewListCommunities')->name('communities');
        Route::get('/comunidades/agregar', 'ObjectivePanelController@viewAddCommunities')->name('communities.add');
        Route::post('/comunidades/agregar', 'ObjectivePanelController@formAddCommunities')->name('communities.add.form');
        Route::delete('/comunidades/{communityId}/eliminar', 'ObjectivePanelController@formRemoveCommunities')->name('communities.remove.form');
        // Metas
        Route::get('/metas', 'ObjectivePanelController@viewListGoals')->name('goals');
        Route::get('/metas/descargar', 'ObjectivePanelController@downloadListGoals')->name('goals.download');
        Route::get('/metas/nuevo', 'ObjectivePanelController@viewAddGoal')->name('goals.add');
        Route::post('/metas/nuevo', 'ObjectivePanelController@formAddGoal')->name('goals.add.form');
        Route::get('/metas/{goalId}', 'GoalPanelController@viewGoal')->name('goals.index');
        Route::get('/metas/{goalId}/editar', 'GoalPanelController@viewEditGoal')->name('goals.edit');
        Route::put('/metas/{goalId}/editar', 'GoalPanelController@formEditGoal')->name('goals.edit.form');
        // Hitos
        Route::get('/metas/{goalId}/hitos', 'GoalPanelController@viewListGoalMilestones')->name('goals.milestones');
        Route::get('/metas/{goalId}/hitos/nuevo', 'GoalPanelController@viewAddGoalMilestone')->name('goals.milestones.add');
        Route::post('/metas/{goalId}/hitos/nuevo', 'GoalPanelController@formAddGoalMilestone')->name('goals.milestones.add.form');
        Route::get('/metas/{goalId}/hitos/{milestoneId}/editar', 'GoalPanelController@viewEditGoalMilestone')->name('goals.milestones.edit');
        Route::put('/metas/{goalId}/hitos/{milestoneId}/editar', 'GoalPanelController@formEditGoalMilestone')->name('goals.milestones.edit.form');
        Route::get('/metas/{goalId}/hitos/{milestoneId}/eliminar', 'GoalPanelController@viewDeleteGoalMilestone')->name('goals.milestones.delete');
        Route::delete('/metas/{goalId}/hitos/{milestoneId}/eliminar', 'GoalPanelController@formDeleteGoalMilestone')->name('goals.milestones.delete.form');
        Route::get('/metas/{goalId}/configuracion', 'GoalPanelController@viewGoalConfiguration')->name('goals.configuration');
        Route::delete('/metas/{goalId}/eliminar', 'GoalPanelController@formDeleteGoal')->name('goals.delete.form');
        // Reporte
        Route::get('/metas/{goalId}/reportes', 'GoalPanelController@viewListGoalReports')->name('goals.reports');
        Route::get('/metas/{goalId}/reportes/descargar', 'GoalPanelController@downloadListGoalReports')->name('goals.reports.download');
        Route::get('/metas/{goalId}/reportes/nuevo', 'GoalPanelController@viewNewGoalReport')->name('goals.reports.add');
        Route::post('/metas/{goalId}/reportes/nuevo', 'GoalPanelController@formNewGoalReport')->name('goals.reports.add.form');
        Route::get('/metas/{goalId}/reportes/{reportId}', 'ReportPanelController@viewReport')->name('goals.reports.index');
        Route::get('/metas/{goalId}/reportes/{reportId}/editar', 'ReportPanelController@viewEditReport')->name('goals.reports.edit');
        Route::put('/metas/{goalId}/reportes/{reportId}/editar', 'ReportPanelController@formEditReport')->name('goals.reports.edit.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/comentarios', 'ReportPanelController@viewReportComments')->name('goals.reports.comments');
        Route::get('/metas/{goalId}/reportes/{reportId}/comentarios/descargar', 'ReportPanelController@downloadReportComments')->name('goals.reports.comments.download');
        Route::get('/metas/{goalId}/reportes/{reportId}/feedbacks', 'ReportPanelController@viewReportTestimonies')->name('goals.reports.testimonies');
        Route::get('/metas/{goalId}/reportes/{reportId}/feedbacks/descargar', 'ReportPanelController@downloadReportTestimonies')->name('goals.reports.testimonies.download');
        Route::get('/metas/{goalId}/reportes/{reportId}/archivos', 'ReportPanelController@viewReportFiles')->name('goals.reports.files');
        Route::post('/metas/{goalId}/reportes/{reportId}/archivos', 'ReportPanelController@formReportFile')->name('goals.reports.files.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/album', 'ReportPanelController@viewReportAlbum')->name('goals.reports.album');
        Route::post('/metas/{goalId}/reportes/{reportId}/album', 'ReportPanelController@formReportAlbum')->name('goals.reports.album.form');
        Route::delete('/metas/{goalId}/reportes/{reportId}/album/{pictureId}/eliminar', 'ReportPanelController@formDeletePictureReport')->name('goals.reports.album.delete.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/mapa', 'ReportPanelController@viewReportMap')->name('goals.reports.map');
        Route::put('/metas/{goalId}/reportes/{reportId}/mapa', 'ReportPanelController@formReportMap')->name('goals.reports.map.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/configuracion', 'ReportPanelController@viewReportConfiguration')->name('goals.reports.configuration');
        Route::delete('/metas/{goalId}/reportes/{reportId}/eliminar', 'ReportPanelController@formDeleteReport')->name('goals.reports.delete.form');
    });
});

