<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Agenda;

class AgendasController extends Controller
{
	public $show_action = true;
	public $view_col = 'nome';
	public $view_col_agendamentos = 'data';
	public $listing_cols = ['id', 'nome', 'aplicador', 'agendamentos'];
	public $listing_cols_agendamentos = ['id', 'data', 'aplicador', 'paciente'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Agendas', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Agendas', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Agendas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Agendas');
		
		if(Module::hasAccess($module->id)) {
			return View('la.agendas.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for creating a new agenda.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created agenda in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Agendas", "create")) {

			$rules = Module::validateRules("Agendas", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Agendas", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.agendas.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified agenda.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Agendas", "view")) {
			
			$agenda = Agenda::find($id);
			if(isset($agenda->id)) {
				$module = Module::get('Agendas');
				$module->row = $agenda;
				
				return view('la.agendas.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('agenda', $agenda);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("agenda"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified agenda.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Agendas", "edit")) {			
			$agenda = Agenda::find($id);
			if(isset($agenda->id)) {	
				$module = Module::get('Agendas');
				
				$module->row = $agenda;
				
				return view('la.agendas.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('agenda', $agenda);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("agenda"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified agenda in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Agendas", "edit")) {
			
			$rules = Module::validateRules("Agendas", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Agendas", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.agendas.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified agenda from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Agendas", "delete")) {
			Agenda::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.agendas.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('agendas')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Agendas');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/agendas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Agendas", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/agendas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Agendas", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.agendas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function agenda_dados()
	{
		$values = DB::table('agendamentos')->select($this->listing_cols_agendamentos)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Agendamentos');
		
		for($i=0; $i < count($data->data); $i++) {

			for ($j=0; $j < count($this->listing_cols_agendamentos); $j++) { 
				$col = $this->listing_cols_agendamentos[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col_agendamentos) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/agendamentos/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			/*if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Agendamentos", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/agendamentos/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Agendamentos", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.agendamentos.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}*/
		}
		$out->setData($data);
		return $out;
	}
}
