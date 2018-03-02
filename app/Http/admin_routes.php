<?php

/* ================== Homepage ================== */
Route::get('/', function () {
	return redirect('admin');
});

Route::get('/home', function () {
	return redirect('admin');
});

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
	Route::get(config('laraadmin.adminRoute') . '/ajaxaplicadores', 'LA\DashboardController@ajaxaplicadores');
	Route::get(config('laraadmin.adminRoute') . '/ajaxpacientes1', 'LA\DashboardController@ajaxpacientes1');
	
	/* ================== Usuarios ================== */
	Route::resource(config('laraadmin.adminRoute') . '/usuarios', 'LA\UsuariosController');
	Route::get(config('laraadmin.adminRoute') . '/usuarios_dt_ajax', 'LA\UsuariosController@dtajax');
	
	
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







	/* ================== Events ================== */
	Route::resource(config('laraadmin.adminRoute') . '/events', 'LA\EventsController');
	Route::get(config('laraadmin.adminRoute') . '/event_dt_ajax', 'LA\EventsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/ajaxpacientes2', 'LA\EventsController@ajaxpacientes2');

	/* ================== Convenios ================== */
	Route::resource(config('laraadmin.adminRoute') . '/convenios', 'LA\ConveniosController');
	Route::get(config('laraadmin.adminRoute') . '/convenio_dt_ajax', 'LA\ConveniosController@dtajax');



	/* ================== Atendimentos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/atendimentos', 'LA\AtendimentosController');
	Route::get(config('laraadmin.adminRoute') . '/atendimento_dt_ajax', 'LA\AtendimentosController@dtajax');

	/* ================== Role_Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/role_users', 'LA\Role_UsersController');
	Route::get(config('laraadmin.adminRoute') . '/role_user_dt_ajax', 'LA\Role_UsersController@dtajax');

	/* ================== Profissoes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/profissoes', 'LA\ProfissoesController');
	Route::get(config('laraadmin.adminRoute') . '/profisso_dt_ajax', 'LA\ProfissoesController@dtajax');
});
