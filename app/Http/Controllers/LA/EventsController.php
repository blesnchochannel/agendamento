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

use App\Models\Event;
use App\Models\Usuario;
use Calendar;

class EventsController extends Controller
{
	public $show_action = true;
	public $view_col = 'aplicador';
	public $listing_cols = ['id', 'aplicador', 'paciente', 'all_day', 'start_date', 'end_date', 'tempo'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Events', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Events', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Events.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$aplicadores = DB::table('usuarios')->select('id', 'nome', 'cor')->where('tipo', 2)->get();

		$q = "all";

		if (isset($_GET['q'])) {
			$q = intval($_GET['q']);
		}
		if ($q == "all"){
			$data = DB::table('events')
			->join('usuarios', 'usuarios.id', '=', 'events.aplicador')
			->join('pacientes', 'pacientes.id', '=', 'events.paciente')
			->select('events.*', 'usuarios.nome as aplicador', 'usuarios.cor as back_cor', 'pacientes.nome as paciente')
			->where('events.deleted_at', '=', null)
			->get();
		}else{
			$data = DB::table('events')
			->join('usuarios', 'usuarios.id', '=', 'events.aplicador')
			->join('pacientes', 'pacientes.id', '=', 'events.paciente')
			->select('events.*', 'usuarios.nome as aplicador', 'usuarios.cor as back_cor', 'pacientes.nome as paciente')
			->where('events.deleted_at', '=', null)
			->where('events.aplicador', '=', $q)
			->get();
		}

		$events = [];

		//if($data->count()){
		foreach ($data as $key => $value) {
			$events[] = Calendar::event(
					"Paciente: ".$value->paciente, //Event title
                	$value->all_day, //Full day event
                	new \DateTime($value->start_date), //Start time
                	new \DateTime($value->end_date), //End time
                	$value->id, //Event ID
                	[
                		'backgroundColor' => $value->back_cor,
                		'borderColor' => $value->back_cor,
                		//'description' => $value->status,
                	]                
                );
		}
		//}

		$calendar = Calendar::addEvents($events);

		$module = Module::get('Events');

		if(Module::hasAccess($module->id)) {
			return View('la.events.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'calendar' => $calendar,
				'aplicadores' => $aplicadores,
				'module' => $module
			]);
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for creating a new event.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created event in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Events", "create")) {

			$rules = Module::validateRules("Events", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Events", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.events.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified event.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Events", "view")) {
			
			$event = Event::find($id);
			if(isset($event->id)) {
				$module = Module::get('Events');
				$module->row = $event;
				
				return view('la.events.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('event', $event);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("event"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified event.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Events", "edit")) {			
			$event = Event::find($id);
			if(isset($event->id)) {	
				$module = Module::get('Events');
				
				$module->row = $event;
				
				return view('la.events.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('event', $event);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("event"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified event in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Events", "edit")) {
			
			$rules = Module::validateRules("Events", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Events", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.events.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified event from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Events", "delete")) {
			Event::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.events.index');
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
		$values = DB::table('events')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Events');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/events/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Events", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/events/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Events", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.events.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

	public function ajaxpacientes2()
	{
		setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');

		$q = intval($_GET['q']);

		$data = DB::table('events')
		->join('pacientes', 'pacientes.id', '=', 'events.paciente')
		->join('planos', 'planos.id', '=', 'pacientes.plano')
		->select('events.*', 'pacientes.nome as paciente', 'planos.nome as plano', 'pacientes.id as paciente_id', 'planos.tempo as limite')
		->where('events.deleted_at', '=', null)
		->where('events.paciente', '=', $q)
		->get();

		$resultado = [];
		foreach ($data as $key => $value)
		{

			$id = $value->paciente_id;
			$paciente = $value->paciente;
			$plano = $value->plano;
			$limite = $value->limite;
			$time = strtotime($value->start_date);
			$ano = date("Y", $time);
			$year[$id] = $ano;

			if (isset($tempo[$ano][$id]))
			{
				$tempo[$ano][$id] += $value->tempo;
			}
			else
			{
				$tempo[$ano][$id] = $value->tempo;
			}

			$resultado[$ano][$id] = ['ano' => $year[$id], 'nome' => $paciente, 'tempo' => $tempo[$ano][$id], 'plano' => $plano, 'limite' => $limite];
		}

		foreach ($resultado as $key => $value) {
			foreach ($resultado[$key] as $key2 => $value2) {
				if (date('Y') == $value2["ano"]){ 
					if($value2["tempo"] >= $value2["limite"]){				
						echo "<span>O paciente já atingiu ".$value2["tempo"]."/".$value2["limite"]." horas do plano ".$value2["plano"].".</span>";
					}else{
						echo "<span>O paciente já atingiu ".$value2["tempo"]."/".$value2["limite"]." horas do plano ".$value2["plano"].".</span>";
					}
				}
			}
		}        
	}
}
