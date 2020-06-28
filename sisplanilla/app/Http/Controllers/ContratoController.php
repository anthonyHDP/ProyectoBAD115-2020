<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;
use App\Puesto;
use App\Empleado;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $contratos = Contrato::orderBy('codigo_contrato', 'desc')->paginate(6);
        }
        else{
            $contratos = Contrato::where($criterio, 'like', '%'. $buscar . '%')->orderBy('codigo_contrato', 'desc')->paginate(6);
        }

        return [
            'pagination' => [
                'total'        => $contratos->total(),
                'current_page' => $contratos->currentPage(),
                'per_page'     => $contratos->perPage(),
                'last_page'    => $contratos->lastPage(),
                'from'         => $contratos->firstItem(),
                'to'           => $contratos->lastItem(),
            ],
            'contratos' => $contratos
        ];
    }
   //LISTAR PUESTOS
     public function selectPuestos(Request $request){
    if (!$request->ajax()) return redirect('/');
    $puestos = Puesto::select('codigo_profesion','nombre')->orderBy('nombre', 'asc')->get();
    return ['puestos' => $puestos];

    }
    //LISTAR EMPLEADOS
    public function selectEmpleados(Request $request){

        //if (!$request->ajax()) return redirect('/');

        $buscarCodigo = $request->codigo_empleado;

        //$contrato = Contrato::where('codigo_empleado', '=', $buscarCodigo)->exists();   
        
        $empleado = Empleado::select('primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido')
                            ->where('codigo_empleado', '=', $buscarCodigo)
                            ->get();
        
        if(!$usuario){
            return ['empleado' => $empleado];
        }else{
            return ['empleado' => $empleado, 'bandera' => '0'];
        }


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contratos = new Contrato();
        //$contratos->codigo_empleado = $request->codigo_empleado;
        $contratos->codigo_puesto = $request->codigo_puesto;
        $contratos->tipo = $request->tipo;
        $contratos->fecha_inicio = $request->fecha_inicio;
        $contratos->fecha_final = $request->fecha_final;
        $contratos->duracion = $request->duracion;
        $contratos->salario = $request->salario;
        $contratos->vigencia = $request->vigencia;
        $contratos->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contratos = Contrato::findOrFail($request->id_contrato);
        //$contratos->codigo_empleado = $request->codigo_empleado;
        $contratos->codigo_puesto = $request->codigo_puesto;
        $contratos->tipo = $request->tipo;
        $contratos->fecha_inicio = $request->fecha_inicio;
        $contratos->fecha_final = $request->fecha_final;
        $contratos->duracion = $request->duracion;
        $contratos->salario = $request->salario;
        $contratos->vigencia = $request->vigencia;
        $privilegio->save();
    }

    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->codigo_contrato);
        $contrato->delete();
    }

    /* public function activar(Request $request)
    {
        $privilegio = Privilegio::findOrFail($request->id_privilegio);
        $privilegio->condicion = '1';
        $privilegio->save();
    } */

   
   
}