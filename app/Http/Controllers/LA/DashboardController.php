<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Models\Event;
use App\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $data = DB::table('events')
        ->join('users', 'users.id', '=', 'events.aplicador')
        ->join('pacientes', 'pacientes.id', '=', 'events.paciente')
        ->select('events.*', 'users.nome as aplicador', 'users.cor as back_cor', 'pacientes.nome as paciente', 'users.id as aplicador_id')
        ->whereNull('events.deleted_at')
        ->get();

        $resultado = [];

        foreach ($data as $key => $value) {
            $tempo = $value->tempo;
            $id = $value->aplicador_id;
            $aplicador = $value->aplicador;
            $resultado[] = ['nome' => $aplicador, 'tempo' => $tempo];// = $aplicador = $tempo;
            //$resultado = array_add(['nome' => $aplicador, 'tempo' => $tempo]);
        }

        var_dump($resultado);

        //return view('la.dashboard', ['resultado' => $resultado]);
    }
}