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
use App\Models\Usuario;

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
        $aplicadores = DB::table('usuarios')
        ->select('id', 'nome', 'cor')
        ->where('tipo', '=', '2', 'and', 'deleted_at', '=', null)
        ->get();

        $pacientes = DB::table('pacientes')
        ->select('id', 'nome')
        ->where('deleted_at', '=', null)
        ->get();

        return view('la.dashboard', ['aplicadores' => $aplicadores, 'pacientes' => $pacientes]);
    }

    public function ajaxaplicadores()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $q = intval($_GET['q']);

        $data = DB::table('events')
        ->join('usuarios', 'usuarios.id', '=', 'events.aplicador')
        ->select('events.*', 'usuarios.tipo as tipo' ,'usuarios.nome as aplicador', 'usuarios.cor as back_cor', 'usuarios.id as aplicador_id', 'usuarios.valor as valor')
        ->where('events.deleted_at', '=', null)
        ->where('tipo', '=', '2')
        ->where('events.aplicador', '=', $q)
        ->get();

        $resultado = [];
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
                $tempo[$ano][$mes][$id] += $value->tempo_de_atendimento;
            }
            else
            {
                $tempo[$ano][$mes][$id] = $value->tempo_de_atendimento;
            }

            $resultado[$ano][$mes][$id] = ['ano' => $year[$id], 'mes' => $month[$id],'nome' => $aplicador, 'tempo' => $tempo[$ano][$mes][$id], 'valor' => $valor];
        }

        echo "
        <table class='table' id='aplicadores'>
        <tr>
        <th>Ano</th>
        <th>Mês</th>
        <th>Horas Trabalhadas</th>
        <th>Valor/Hora</th>
        <th>Valor Total</th>
        </tr>
        ";

        foreach ($resultado as $key => $value) {
            foreach ($resultado[$key] as $key2 => $value2) {
                foreach ($resultado[$key][$key2] as $key3 => $value3) {
                    echo "
                    <tr>
                    <td>".$value3["ano"]."</td>
                    <td>".$value3["mes"]."</td>
                    <td>".$value3["tempo"]." horas</td>
                    <td>R$ ".$value3["valor"]."</td>
                    <td>R$ ".$value3["tempo"]*$value3["valor"]."</td>
                    </tr>
                    ";                    
                }
            }
        }

        echo "</table>";        
    }

    public function ajaxpacientes1()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $q = intval($_GET['q']);

        $data = DB::table('events')
        ->join('pacientes', 'pacientes.id', '=', 'events.paciente')
        ->join('planos', 'planos.id', '=', 'pacientes.plano')
        ->select('events.*', 'pacientes.nome as paciente', 'planos.nome as plano', 'pacientes.id as paciente_id', 'planos.descricao as descricao')
        ->where('events.deleted_at', '=', null)
        ->where('events.paciente', '=', $q)
        ->get();

        $resultado = [];
        foreach ($data as $key => $value)
        {

            $id = $value->paciente_id;
            $paciente = $value->paciente;
            $plano = $value->plano;
            $descricao = $value->descricao;
            $time = strtotime($value->start_date);
            $mes = strftime('%B', $time);
            $ano = date("Y", $time);
            $year[$id] = $ano;
            $month[$id] = $mes;

            if (isset($tempo[$ano][$mes][$id]))
            {
                $tempo[$ano][$mes][$id] += $value->tempo_de_atendimento;
            }
            else
            {
                $tempo[$ano][$mes][$id] = $value->tempo_de_atendimento;
            }

            $resultado[$ano][$mes][$id] = ['ano' => $year[$id], 'mes' => $month[$id],'nome' => $paciente, 'tempo' => $tempo[$ano][$mes][$id], 'plano' => $plano, 'descricao' => $descricao];
        }

        echo "
        <table class='table' id='aplicadores'>
        <tr>
        <th>Ano</th>
        <th>Mês</th>
        <th>Horas em Atendimento</th>
        <th>Plano</th>
        <th>Descrição</th>
        </tr>
        ";

        foreach ($resultado as $key => $value) {
            foreach ($resultado[$key] as $key2 => $value2) {
                foreach ($resultado[$key][$key2] as $key3 => $value3) {
                    echo "
                    <tr>
                    <td>".$value3["ano"]."</td>
                    <td>".$value3["mes"]."</td>
                    <td>".$value3["tempo"]." horas</td>
                    <td>".$value3["plano"]."</td>
                    <td>".$value3["descricao"]."</td>
                    </tr>
                    ";                    
                }
            }
        }

        echo "</table>";        
    }

}