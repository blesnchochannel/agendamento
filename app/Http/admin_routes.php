<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	
	



	/* ================== Planos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/planos', 'LA\PlanosController');
	Route::get(config('laraadmin.adminRoute') . '/plano_dt_ajax', 'LA\PlanosController@dtajax');

	/* ================== Tipos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/tipos', 'LA\TiposController');
	Route::get(config('laraadmin.adminRoute') . '/tipo_dt_ajax', 'LA\TiposController@dtajax');

	/* ================== Pacientes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/pacientes', 'LA\PacientesController');
	Route::get(config('laraadmin.adminRoute') . '/paciente_dt_ajax', 'LA\PacientesController@dtajax');

	/* ================== Agendamentos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/agendamentos', 'LA\AgendamentosController');
	Route::get(config('laraadmin.adminRoute') . '/agendamento_dt_ajax', 'LA\AgendamentosController@dtajax');



	/* ================== Agendas ================== */
	Route::resource(config('laraadmin.adminRoute') . '/agendas', 'LA\AgendasController');
	Route::get(config('laraadmin.adminRoute') . '/agenda_dt_ajax', 'LA\AgendasController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/agenda_dados', 'LA\AgendasController@agenda_dados');

});
