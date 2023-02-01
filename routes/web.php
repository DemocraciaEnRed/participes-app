<?php

use App\Http\Controllers\MiscController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserPanelController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\ObjectivePanelController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GoalPanelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportPanelController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/start', [MiscController::class, 'start'])->name('start');
Route::post('/start', [MiscController::class, 'startApp'])->name('start.form');
// Route::get('/testmail', [MiscController::class, 'testEmail'])->name('misc.testEmail');
Route::get('/testing', [MiscController::class, 'testing'])->name('testing');

Route::group([
    'as' => 'about.', 
    'prefix' => 'acerca', 
    ],function () {
    Route::get('/general', [HomeController::class, 'viewAboutGeneral'])->name('general');
    Route::get('/faq', [HomeController::class, 'viewAboutQuestions'])->name('faq');
    Route::get('/legales', [HomeController::class, 'viewAboutLegals'])->name('legal');
});

Route::group([
    'as' => 'aboutTwo.', 
    'prefix' => 'acerca2', 
    ],function () {
    Route::get('/general', [HomeController::class, 'viewAboutGeneralTwo'])->name('general');
    Route::get('/faq', [HomeController::class, 'viewAboutQuestionsTwo'])->name('faq');
    Route::get('/legales', [HomeController::class, 'viewAboutLegalsTwo'])->name('legal');
});

Route::group([
    'as' => 'events.', 
    'prefix' => 'eventos', 
    ],function () {
    Route::get('/', [EventController::class, 'showUpcomingEvents'])->name('upcoming');
    Route::get('/pasados', [EventController::class, 'showPastEvents'])->name('past');
    Route::get('/{eventId}', [EventController::class, 'index'])->name('index');
});

Auth::routes(['verify' => true]);

Route::group([
    'as' => 'panel.', 
    'prefix' => 'panel', 
    ],function () {
    Route::get('/', [UserPanelController::class, 'index'])->name('index');
    // Mis objetivos
    Route::get('/objetivos', [UserPanelController::class, 'viewListObjectives'])->name('objectives');
    // Mis suscripciones
    Route::get('/suscripciones', [UserPanelController::class, 'viewListSubscriptions'])->name('subscriptions');
    Route::post('/suscripciones/{objectiveId}/desuscribir', [UserPanelController::class, 'formUnsubSubscription'])->name('subscriptions.unsubscribe.form');
    // Mis notificaciones
    Route::get('/notificaciones', [UserPanelController::class, 'viewListNotifications'])->name('notifications');
    Route::get('/notificaciones/pendientes', [UserPanelController::class, 'viewListUnreadNotifications'])->name('notifications.unread');
    Route::post('/notificaciones/pendientes/marcar', [UserPanelController::class, 'formMarkAllUnreadNotifications'])->name('notifications.mark.all.form');
    Route::post('/notificaciones/eliminar', [UserPanelController::class, 'formDeleteAllNotifications'])->name('notifications.delete.all.form');
    // Mi cuenta
    Route::get('/preferencias/verificar', [UserPanelController::class, 'viewVerifyAccount'])->name('account.verify');
    Route::get('/preferencias/datos', [UserPanelController::class, 'viewAccountData'])->name('account.data');
    Route::put('/preferencias/datos', [UserPanelController::class, 'formAccountData'])->name('account.data.form');
    Route::get('/preferencias/avatar', [UserPanelController::class, 'viewAccountAvatar'])->name('account.avatar');
    Route::post('/preferencias/avatar', [UserPanelController::class, 'formAccountAvatar'])->name('account.avatar.form');
    Route::get('/preferencias/acceso', [UserPanelController::class, 'viewAccountAccess'])->name('account.access');
    Route::put('/preferencias/acceso', [UserPanelController::class, 'formAccountAccess'])->name('account.access.form');
    Route::get('/preferencias/email', [UserPanelController::class, 'viewAccountEmail'])->name('account.email');
    Route::put('/preferencias/email', [UserPanelController::class, 'formAccountEmail'])->name('account.email.form');
    Route::get('/preferencias/notificationes', [UserPanelController::class, 'viewAccountNotifications'])->name('account.notifications');
    Route::put('/preferencias/notificationes', [UserPanelController::class, 'formAccountNotifications'])->name('account.notifications.form');
});

Route::group([
    'as' => 'admin.', 
    'prefix' => 'admin', 
    ],function () {
    Route::get('/', [AdminPanelController::class, 'index'])->name('index');
    Route::get('/bitacora', [AdminPanelController::class, 'viewLogs'])->name('logs');
    // Settings
    Route::get('/configuracion/editar', [AdminPanelController::class, 'viewEditSettings'])->name('settings');
    Route::get('/configuracion/editar', [AdminPanelController::class, 'viewEditSettings'])->name('settings');
    Route::put('/configuracion/editar', [AdminPanelController::class, 'formEditSetting'])->name('settings.form');
    Route::put('/configuracion/editar/file', [AdminPanelController::class, 'formEditFileSetting'])->name('settings.form.file');
    Route::get('/configuracion/editar/map', [AdminPanelController::class, 'viewEditMapSettings'])->name('settings.map');
    Route::put('/configuracion/editar/map/default', [AdminPanelController::class, 'formEditMapSetting'])->name('settings.map.form');
    Route::get('/configuracion/editar/homepage', [AdminPanelController::class, 'viewEditHomepageSettings'])->name('settings.homepage');
    Route::get('/configuracion/editar/seo', [AdminPanelController::class, 'viewEditSeoSettings'])->name('settings.seo');
    Route::post('/configuracion/cache', [AdminPanelController::class, 'clearCacheSettings'])->name('settings.cache');
    // Categorias
    Route::get('/categorias', [AdminPanelController::class, 'viewListCategories'])->name('categories');
    Route::get('/categorias/nuevo', [AdminPanelController::class, 'viewCreateCategory'])->name('categories.create');
    Route::post('/categorias/nuevo', [AdminPanelController::class, 'formCreateCategory'])->name('categories.create.form');
    Route::get('/categorias/{categoryId}/editar', [AdminPanelController::class, 'viewEditCategory'])->name('categories.edit');
    Route::put('/categorias/{categoryId}/editar', [AdminPanelController::class, 'formEditCategory'])->name('categories.edit.form');
    Route::get('/categorias/{categoryId}/eliminar', [AdminPanelController::class, 'viewDeleteCategory'])->name('categories.delete');
    Route::delete('/categorias/{categoryId}/eliminar', [AdminPanelController::class, 'formDeleteCategory'])->name('categories.delete.form');
    // Organizaciones
    Route::get('/organizaciones', [AdminPanelController::class, 'viewListOrganizations'])->name('organizations');
    Route::get('/organizaciones/nuevo', [AdminPanelController::class, 'viewCreateOrganization'])->name('organizations.create');
    Route::post('/organizaciones/nuevo', [AdminPanelController::class, 'formCreateOrganization'])->name('organizations.create.form');
    Route::get('/organizaciones/{organizationId}/editar', [AdminPanelController::class, 'viewEditOrganization'])->name('organizations.edit');
    Route::put('/organizaciones/{organizationId}/editar', [AdminPanelController::class, 'formEditOrganization'])->name('organizations.edit.form');
    Route::get('/organizaciones/{organizationId}/eliminar', [AdminPanelController::class, 'viewDeleteOrganization'])->name('organizations.delete');
    Route::delete('/organizaciones/{organizationId}/eliminar', [AdminPanelController::class, 'formDeleteOrganization'])->name('organizations.delete.form');
    // Administradores
    Route::get('/administradores', [AdminPanelController::class, 'viewListAdministrators'])->name('administrators');
    Route::get('/administradores/nuevo', [AdminPanelController::class, 'viewAddAdministrator'])->name('administrators.add');
    Route::post('/administradores/nuevo', [AdminPanelController::class, 'formAddAdministrator'])->name('administrators.add.form');
    Route::delete('/administradores/{adminId}/eliminar', [AdminPanelController::class, 'formDeleteAdministrator'])->name('administrators.delete.form');
    // Objectives
    Route::get('/objetivos', [AdminPanelController::class, 'viewListObjectives'])->name('objectives');
    Route::get('/objetivos/descargar', [AdminPanelController::class, 'downloadListObjectives'])->name('objectives.download');
    Route::get('/objetivos/nuevo', [AdminPanelController::class, 'viewCreateObjective'])->name('objectives.create');
    Route::post('/objetivos/nuevo', [AdminPanelController::class, 'formCreateObjective'])->name('objectives.create.form');
    // Events
    Route::get('/eventos', [AdminPanelController::class, 'viewUpcomingEvents'])->name('events');
    Route::get('/eventos/pasados', [AdminPanelController::class, 'viewPastEvents'])->name('events.past');
    Route::get('/eventos/nuevo', [AdminPanelController::class, 'viewCreateEvent'])->name('events.create');
    Route::post('/eventos/nuevo', [AdminPanelController::class, 'formCreateEvent'])->name('events.create.form');
    Route::get('/eventos/{eventId}/editar', [AdminPanelController::class, 'viewEditEvent'])->name('events.edit');
    Route::put('/eventos/{eventId}/editar', [AdminPanelController::class, 'formEditEvent'])->name('events.edit.form');
    Route::post('/eventos/{eventId}/fotos/agregar', [AdminPanelController::class, 'formAddPictureEvent'])->name('events.pictures.add');
    Route::delete('/eventos/{eventId}/fotos/{pictureId}/eliminar', [AdminPanelController::class, 'formDeletePictureEvent'])->name('events.pictures.delete');
    Route::get('/eventos/{eventId}/eliminar', [AdminPanelController::class, 'viewDeleteEvent'])->name('events.delete');
    Route::delete('/eventos/{eventId}/eliminar', [AdminPanelController::class, 'formDeleteEvent'])->name('events.delete.form');
    // Preguntas Frecuentes
    Route::get('/preguntas-frecuentes', [AdminPanelController::class, 'viewListFaqs'])->name('faqs');
    Route::get('/preguntas-frecuentes/nuevo', [AdminPanelController::class, 'viewCreateFaq'])->name('faqs.create');
    Route::post('/preguntas-frecuentes/nuevo', [AdminPanelController::class, 'formCreateFaq'])->name('faqs.create.form');
    Route::get('/preguntas-frecuentes/{faqId}/editar', [AdminPanelController::class, 'viewEditFaq'])->name('faqs.edit');
    Route::put('/preguntas-frecuentes/{faqId}/editar', [AdminPanelController::class, 'formEditFaq'])->name('faqs.edit.form');
    Route::get('/preguntas-frecuentes/{faqId}/eliminar', [AdminPanelController::class, 'viewDeleteFaq'])->name('faqs.delete');
    Route::delete('/preguntas-frecuentes/{faqId}/eliminar', [AdminPanelController::class, 'formDeleteFaq'])->name('faqs.delete.form');
});

Route::group([
    'as' => 'apiService.', 
    'prefix' => 'api-service', 
    ],function () {
    // Userss
    Route::get('/home/stats', [HomeController::class, 'fetchStats'])->name('home.stats');
    Route::get('/users', [UserController::class, 'fetch'])->name('users');
    Route::get('/users/avatar', [UserController::class, 'fetchAvatar'])->name('users.avatar');
    Route::get('/users/{id}', [UserController::class, 'fetchOne'])->name('users.fetch');
    Route::put('/notification/read', [NotificationController::class, 'markAllRead'])->name('notification.mark.all');
    Route::put('/notification/read/{id}', [NotificationController::class, 'markOneRead'])->name('notification.mark.one');
    Route::delete('/notification/clean', [NotificationController::class, 'cleanAll'])->name('notification.clean');
    Route::get('/reports', [ReportController::class, 'fetch'])->name('reports');
    Route::get('/reports/{reportId}/comments', [ReportController::class, 'fetchComments'])->name('reports.comments');
    Route::post('/reports/{reportId}/comments', [ReportController::class, 'runCreateComment'])->name('reports.comments.create');
    Route::put('/reports/{reportId}/comments/{commentId}/edit', [ReportController::class, 'runEditComment'])->name('reports.comments.edit');
    Route::post('/reports/{reportId}/comments/{commentId}/reply', [ReportController::class, 'runCreateReply'])->name('reports.comments.reply');
    Route::delete('/reports/{reportId}/comments/{commentId}/delete', [ReportController::class, 'runDeleteComment'])->name('reports.comments.delete');
    Route::put('/reports/{reportId}/comments/{commentId}/reply/{replyId}/edit', [ReportController::class, 'runEditReply'])->name('reports.comments.reply.edit');
    Route::delete('/reports/{reportId}/comments/{commentId}/reply/{replyId}/delete', [ReportController::class, 'runDeleteReply'])->name('reports.comments.reply.delete');
    Route::post('/reports/{reportId}/testimony', [ReportController::class, 'runToggleTestimony'])->name('reports.testimonies.run');
    Route::get('/objectives', [ObjectiveController::class, 'fetch'])->name('objectives');
    Route::get('/objectives/{objectiveId}', [ObjectiveController::class, 'fetchOne'])->name('objectives.fetch');
    Route::get('/objectives/{objectiveId}/reports', [ObjectiveController::class, 'fetchReports'])->name('objectives.reports');
    Route::get('/objectives/{objectiveId}/stats', [ObjectiveController::class, 'fetchStats'])->name('objectives.stats');
    Route::get('/goal/{goalId}/reports', [GoalController::class, 'fetchReports'])->name('goals.reports');



});

Route::get('/objetivos', [ObjectiveController::class, 'viewList'])->name('objectives');
Route::post('/objetivos/{objectiveId}/subscribirse', [ObjectiveController::class, 'formToggleSubscription'])->name('objectives.subscribers.form');
Route::get('/reportes', [ReportController::class, 'viewList'])->name('reports');
Route::get('/reportes/{reportId}', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reportes/{reportId}/testimony', [ReportController::class, 'formToggleTestimony'])->name('reports.testimonies.form');
Route::get('/metas/{goalId}', [GoalController::class, 'index'])->name('goals.index');

Route::group([
    'as' => 'objectives.', 
    'prefix' => 'objetivos', 
    ],function () {
    Route::get('/{objectiveId}', [ObjectiveController::class, 'index'])->name('index');
    // Manage
    Route::group([
        'as' => 'manage.', 
        'prefix' => '/{objectiveId}/administrar', 
        ],function () {
        Route::get('/', [ObjectivePanelController::class, 'index'])->name('index');
        Route::get('/editar', [ObjectivePanelController::class, 'viewEditObjective'])->name('edit');
        Route::put('/editar', [ObjectivePanelController::class, 'formEditObjective'])->name('edit.form');
        // Administracion
        Route::get('/logs', [ObjectivePanelController::class, 'viewObjectiveLogs'])->name('logs');
        Route::get('/configuracion', [ObjectivePanelController::class, 'viewObjectiveConfiguration'])->name('configuration');
        Route::put('/configuracion/ocultar', [ObjectivePanelController::class, 'formObjectiveConfigurationHide'])->name('configuration.hide.form');
        Route::put('/configuracion/mapa', [ObjectivePanelController::class, 'formObjectiveConfigurationMap'])->name('configuration.map.form');
        Route::get('/portada', [ObjectivePanelController::class, 'viewObjectiveCover'])->name('cover');
        Route::post('/portada', [ObjectivePanelController::class, 'formObjectiveCover'])->name('cover.form');
        Route::get('/archivos', [ObjectivePanelController::class, 'viewObjectiveFiles'])->name('files');
        Route::post('/archivos', [ObjectivePanelController::class, 'formObjectiveFile'])->name('files.form');
        Route::get('/mapa', [ObjectivePanelController::class, 'viewObjectiveMap'])->name('map');
        Route::delete('/eliminar', [ObjectivePanelController::class, 'formDeleteObjective'])->name('delete.form');
        // Suscriptores
        Route::get('/suscriptores', [ObjectivePanelController::class, 'viewListSubscribers'])->name('subscribers');
        Route::get('/suscriptores/descargar', [ObjectivePanelController::class, 'downloadListSubscribers'])->name('subscribers.download');
        // Equipo
        Route::get('/equipo', [ObjectivePanelController::class, 'viewListTeam'])->name('team');
        Route::get('/equipo/agregar', [ObjectivePanelController::class, 'viewAddTeam'])->name('team.add');
        Route::post('/equipo/agregar', [ObjectivePanelController::class, 'formAddTeam'])->name('team.add.form');
        Route::delete('/equipo/{usrId}/eliminar', [ObjectivePanelController::class, 'formRemoveTeam'])->name('team.remove.form');
        // Equipo
        Route::get('/comunidades', [ObjectivePanelController::class, 'viewListCommunities'])->name('communities');
        Route::get('/comunidades/agregar', [ObjectivePanelController::class, 'viewAddCommunities'])->name('communities.add');
        Route::post('/comunidades/agregar', [ObjectivePanelController::class, 'formAddCommunities'])->name('communities.add.form');
        Route::delete('/comunidades/{communityId}/eliminar', [ObjectivePanelController::class, 'formRemoveCommunities'])->name('communities.remove.form');
        // Metas
        Route::get('/metas', [ObjectivePanelController::class, 'viewListGoals'])->name('goals');
        Route::get('/metas/descargar', [ObjectivePanelController::class, 'downloadListGoals'])->name('goals.download');
        Route::get('/metas/nuevo', [ObjectivePanelController::class, 'viewAddGoal'])->name('goals.add');
        Route::post('/metas/nuevo', [ObjectivePanelController::class, 'formAddGoal'])->name('goals.add.form');
        Route::get('/metas/{goalId}', [GoalPanelController::class, 'viewGoal'])->name('goals.index');
        Route::get('/metas/{goalId}/editar', [GoalPanelController::class, 'viewEditGoal'])->name('goals.edit');
        Route::put('/metas/{goalId}/editar', [GoalPanelController::class, 'formEditGoal'])->name('goals.edit.form');
        // Hitos
        Route::get('/metas/{goalId}/hitos', [GoalPanelController::class, 'viewListGoalMilestones'])->name('goals.milestones');
        Route::get('/metas/{goalId}/hitos/nuevo', [GoalPanelController::class, 'viewAddGoalMilestone'])->name('goals.milestones.add');
        Route::post('/metas/{goalId}/hitos/nuevo', [GoalPanelController::class, 'formAddGoalMilestone'])->name('goals.milestones.add.form');
        Route::get('/metas/{goalId}/hitos/{milestoneId}/editar', [GoalPanelController::class, 'viewEditGoalMilestone'])->name('goals.milestones.edit');
        Route::put('/metas/{goalId}/hitos/{milestoneId}/editar', [GoalPanelController::class, 'formEditGoalMilestone'])->name('goals.milestones.edit.form');
        Route::get('/metas/{goalId}/hitos/{milestoneId}/eliminar', [GoalPanelController::class, 'viewDeleteGoalMilestone'])->name('goals.milestones.delete');
        Route::delete('/metas/{goalId}/hitos/{milestoneId}/eliminar', [GoalPanelController::class, 'formDeleteGoalMilestone'])->name('goals.milestones.delete.form');
        Route::get('/metas/{goalId}/configuracion', [GoalPanelController::class, 'viewGoalConfiguration'])->name('goals.configuration');
        Route::delete('/metas/{goalId}/eliminar', [GoalPanelController::class, 'formDeleteGoal'])->name('goals.delete.form');
        // Reporte
        Route::get('/metas/{goalId}/reportes', [GoalPanelController::class, 'viewListGoalReports'])->name('goals.reports');
        Route::get('/metas/{goalId}/reportes/descargar', [GoalPanelController::class, 'downloadListGoalReports'])->name('goals.reports.download');
        Route::get('/metas/{goalId}/reportes/nuevo', [GoalPanelController::class, 'viewNewGoalReport'])->name('goals.reports.add');
        Route::post('/metas/{goalId}/reportes/nuevo', [GoalPanelController::class, 'formNewGoalReport'])->name('goals.reports.add.form');
        Route::get('/metas/{goalId}/reportes/{reportId}', [ReportPanelController::class, 'viewReport'])->name('goals.reports.index');
        Route::get('/metas/{goalId}/reportes/{reportId}/editar', [ReportPanelController::class, 'viewEditReport'])->name('goals.reports.edit');
        Route::put('/metas/{goalId}/reportes/{reportId}/editar', [ReportPanelController::class, 'formEditReport'])->name('goals.reports.edit.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/comentarios', [ReportPanelController::class, 'viewReportComments'])->name('goals.reports.comments');
        Route::get('/metas/{goalId}/reportes/{reportId}/comentarios/descargar', [ReportPanelController::class, 'downloadReportComments'])->name('goals.reports.comments.download');
        Route::get('/metas/{goalId}/reportes/{reportId}/feedbacks', [ReportPanelController::class, 'viewReportTestimonies'])->name('goals.reports.testimonies');
        Route::get('/metas/{goalId}/reportes/{reportId}/feedbacks/descargar', [ReportPanelController::class, 'downloadReportTestimonies'])->name('goals.reports.testimonies.download');
        Route::get('/metas/{goalId}/reportes/{reportId}/archivos', [ReportPanelController::class, 'viewReportFiles'])->name('goals.reports.files');
        Route::post('/metas/{goalId}/reportes/{reportId}/archivos', [ReportPanelController::class, 'formReportFile'])->name('goals.reports.files.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/album', [ReportPanelController::class, 'viewReportAlbum'])->name('goals.reports.album');
        Route::post('/metas/{goalId}/reportes/{reportId}/album', [ReportPanelController::class, 'formReportAlbum'])->name('goals.reports.album.form');
        Route::delete('/metas/{goalId}/reportes/{reportId}/album/{pictureId}/eliminar', [ReportPanelController::class, 'formDeletePictureReport'])->name('goals.reports.album.delete.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/mapa', [ReportPanelController::class, 'viewReportMap'])->name('goals.reports.map');
        Route::put('/metas/{goalId}/reportes/{reportId}/mapa', [ReportPanelController::class, 'formReportMap'])->name('goals.reports.map.form');
        Route::get('/metas/{goalId}/reportes/{reportId}/configuracion', [ReportPanelController::class, 'viewReportConfiguration'])->name('goals.reports.configuration');
        Route::delete('/metas/{goalId}/reportes/{reportId}/eliminar', [ReportPanelController::class, 'formDeleteReport'])->name('goals.reports.delete.form');
    });
});

