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
        $aplicadores = DB::table('users')
        ->select('id', 'nome')
        ->where('tipo', '=', '2', 'and', 'deleted_at', '=', null)
        ->get();

        $data = DB::table('events')
        ->join('users', 'users.id', '=', 'events.aplicador')
        ->select('events.*', 'users.nome as aplicador', 'users.cor as back_cor', 'users.id as aplicador_id', 'users.valor as valor')
        ->whereNull('events.deleted_at')
        ->get();

        $resultado = [];
        foreach ($data as $key => $value)
        {

            $id = $value->aplicador_id;
            $aplicador = $value->aplicador;
            $valor = $value->valor;
            $time = strtotime($value->start_date);
            $mes = date("F", $time);
            $ano = date("Y", $time);
            $year[$id] = $ano;
            $month[$id] = $mes;

            if (isset($tempo[$ano][$mes][$id]))
            {
                $tempo[$ano][$mes][$id] += $value->tempo;
            }
            else
            {
                $tempo[$ano][$mes][$id] = $value->tempo;
            }

            //$resultado[$ano][$mes][$id] = $year[$id] = $month[$id] = ['nome' => $aplicador, 'tempo' => $tempo[$ano][$mes][$id]];
            $resultado[$ano][$mes][$id] = ['ano' => $year[$id], 'mes' => $month[$id],'nome' => $aplicador, 'tempo' => $tempo[$ano][$mes][$id], 'valor' => $valor];
        }

        foreach ($resultado as $key => $value) {
            //echo $value."<br>";
        }

        //var_dump($resultado[2018]);

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
           [
               "label" => "My First dataset",
               'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
               'data' => [69, 59]
           ],
           [
               "label" => "My First dataset",
               'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
               'data' => [65, 12]
           ]
       ])
        ->options([]);
        
        return view('la.dashboard', ['resultado' => $resultado, 'aplicadores' => $aplicadores], compact('chartjs'));
    }

    public function aplicadores()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $q = intval($_GET['q']);

        $data = DB::table('events')
        ->join('users', 'users.id', '=', 'events.aplicador')
        ->select('events.*', 'users.tipo as tipo' ,'users.nome as aplicador', 'users.cor as back_cor', 'users.id as aplicador_id', 'users.valor as valor')
        ->where('events.deleted_at', '=', null)
        ->where('tipo', '=', '2')
        ->where('events.aplicador', '=', $q)
        ->get();

        $resultado = [];
        $resultado2 = [];
        $resultado3 = [];
        $resultado4 = [];
        $resultado5 = [];
        foreach ($data as $key => $value)
        {

            $id = $value->aplicador_id;
            $aplicador = $value->aplicador;
            $valor = $value->valor;
            $time = strtotime($value->start_date);
            $mes = strftime('%B', $time);
            $ano = date("Y", $time);
            $year[$id] = $ano;
            $month[$id] = $mes;

            if (isset($tempo[$ano][$mes][$id]))
            {
                $tempo[$ano][$mes][$id] += $value->tempo;
            }
            else
            {
                $tempo[$ano][$mes][$id] = $value->tempo;
            }

            $resultado[$ano][$mes][$id] = ['ano' => $year[$id], 'mes' => $month[$id],'nome' => $aplicador, 'tempo' => $tempo[$ano][$mes][$id], 'valor' => $valor];
        }

        foreach ($resultado as $key => $value) {
            echo "<div class='agendamentos col-lg-12'>".$key."<br>";
            foreach ($resultado[$key] as $key2 => $value2) {
                echo "<div class='agendamentos col-lg-6'>".$key2."<br>";
                foreach ($resultado[$key][$key2] as $key3 => $value3) {
                    echo "Tempo: ".$value3["tempo"]." horas.<br>";
                    echo "Valor: R$ ".$value3["valor"]." reais.<br>";
                    echo "Total: R$ ".$value3["tempo"]*$value3["valor"]." reais. <br>";
                    
                }
                echo "</div>";
            }
            echo "</div>";
        }

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
           [
               "label" => "My First dataset",
               'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
               'data' => [69, 59]
           ],
           [
               "label" => "My First dataset",
               'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
               'data' => [65, 12]
           ]
       ])
        ->options([]);

        //var_dump($resultado);

        //return $resultado;
    }
}