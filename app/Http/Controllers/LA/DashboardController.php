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
        ->select('events.*', 'users.nome as aplicador', 'users.cor as back_cor', 'pacientes.nome as paciente')
        ->get();

        /*foreach ($data as $key => $value) {
            $timestamp1 = strtotime($value->start_date);
            $timestamp2 = strtotime($value->end_date);
            echo "Difference between two dates is " . $hour = abs($timestamp2 - $timestamp1)/(60*60) . " hour(s)"."<br>";
        }*/

        return view('la.dashboard', ['data' => $data]);
    }
}