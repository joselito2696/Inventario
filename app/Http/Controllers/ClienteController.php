<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empleadodir;
use App\Http\Controllers\DateTime;
use Carbon\Carbon;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $existeCliente = 0;
        $codCliente = '';
        $direccion = '';
        return view('cliente.index', compact('existeCliente', 'codCliente', 'direccion'));
    }
    public function buscar(Request $request)
    {

        $existe = DB::table('clientes')
            ->where('clientes.codCliente', '=', $request->codCliente)
            ->select(DB::raw('sum(clientes.codCliente) as codCliente'))
            ->get();

        if ($existe[0]->codCliente == null) {
            $existeCliente = 0;
            $codCliente = 'Ingrese el codigo Correcto';
            $direccion = '';
            return view('cliente.index', compact('existeCliente', 'codCliente', 'direccion'));
        } else {
            $codCliente = $request->codCliente;
            $direccion = DB::table('clientes as c')
                ->join('clientedireccions as cd', 'cd.codCliente', '=', 'c.codCliente')
                ->where('c.codCliente', '=', $request->codCliente)
                ->select('c.codCliente', 'cd.id', 'c.nombreCliente', 'cd.direccion')
                ->get();
            return view('cliente.buscar', compact('codCliente', 'direccion'));
            //return  redirect()->back()->with(compact('existeCliente'))->withInput(request(['codCliente']));
        }
    }
    public function guardar(Request $request)
    {
        $user = auth()->user()->id;
        $fecha = Carbon::createFromFormat('m/d/Y', $request->fecha)->format('Y-m-d');
        $existe = DB::table('empleadodirs as ed')
            ->where('ed.idUser', '=', $user)
            ->where('ed.idCDir', '=', $request->idDireccion)
            ->where('ed.fecha', '=', $fecha)
            ->select(DB::raw('count(ed.idUser) as idUser'))
            ->get();

        if ($existe[0]->idUser == 0) {
            $guardar = new EmpleadoDir;
            $guardar->idUser = $user;
            $guardar->idCDir = $request->idDireccion;
            $guardar->fecha = $fecha;
            if ($guardar->save()) {
                $existeCliente = 0;
                $codCliente = '';
                $direccion = '';
                return view('cliente.index', compact('existeCliente', 'codCliente', 'direccion'));
            }
        }
        $codCliente = $request->codCliente;

        $direccion = DB::table('clientes as c')
            ->join('clientedireccions as cd', 'cd.codCliente', '=', 'c.codCliente')
            ->where('c.codCliente', '=', $request->codCliente)
            ->select('c.codCliente', 'cd.id', 'c.nombreCliente', 'cd.direccion')
            ->get();
        return view('cliente.buscar', compact('codCliente', 'direccion'));
    }
    public function indexSala(){
        $user = auth()->user()->id;
        $salaRep = DB::table('empleadodirs as ed')
        ->join('clientedireccions as cd','cd.id','=','ed.idCDir')
        ->join('clientes as c','c.codCliente','=','cd.codCliente')
        ->where('ed.idUser', '=', $user)
        ->select('ed.id','ed.idUser','ed.idCDir','ed.fecha','cd.direccion','c.nombreCliente')
        ->get();
        return view('cliente.listadoSala',compact('salaRep'));
    }
}
