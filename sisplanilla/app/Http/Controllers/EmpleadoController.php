<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Empleado;
use App\Contactos_Telefonicos;
use App\Tipos_Contacto_Telefonico;
use App\Direccion;
use App\Estados_Civiles;
use App\Generos;
use App\Profesiones;
use App\Municipio;
use App\Departamento;
use App\Documentos_Identificacion;
use App\Tipos_Identificacion;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            //$empleados = Empleado::orderBy('codigo_empleado', 'desc')->paginate(10);

            $empleados = Empleado::join('generos','empleados.id_genero','=','generos.id_genero')
            ->join('profesiones','empleados.codigo_profesion','=','profesiones.codigo_profesion')
            ->select('empleados.codigo_empleado','empleados.id_genero','generos.titulo','empleados.primer_nombre',
            'empleados.segundo_nombre','empleados.primer_apellido','empleados.segundo_apellido',
            'empleados.codigo_jefe','empleados.email_personal','empleados.email_institucional', 'empleados.activo','profesiones.titulo as profest')
            ->orderBy('empleados.codigo_empleado', 'desc')->paginate(6);
          }else{
            if($criterio=='codigo_empleado' || $criterio=='codigo_jefe'){
            $empleados = Empleado::join('generos','empleados.id_genero','=','generos.id_genero')
            ->join('profesiones','empleados.codigo_profesion','=','profesiones.codigo_profesion')
            ->select('empleados.codigo_empleado','empleados.id_genero','generos.titulo','empleados.primer_nombre',
            'empleados.segundo_nombre','empleados.primer_apellido','empleados.segundo_apellido',
            'empleados.codigo_jefe','empleados.email_personal','empleados.email_institucional', 'empleados.activo','profesiones.titulo as profest')
            ->where('empleados.'.$criterio, 'like', '%'. $buscar. '%')
            ->orderBy('empleados.codigo_empleado', 'desc')->paginate(6);
            }else{
                if($criterio=='id_genero' || $criterio=='titulo'){
                    $empleados = Empleado::join('generos','empleados.id_genero','=','generos.id_genero')
                    ->join('profesiones','empleados.codigo_profesion','=','profesiones.codigo_profesion')
                    ->select('empleados.codigo_empleado','empleados.id_genero','generos.titulo','empleados.primer_nombre',
                    'empleados.segundo_nombre','empleados.primer_apellido','empleados.segundo_apellido',
                    'empleados.codigo_jefe','empleados.email_personal','empleados.email_institucional', 'empleados.activo','profesiones.titulo as profest')
                    ->where('generos.'.$criterio, 'like', '%'. $buscar. '%')
                    ->orderBy('generos.titulo', 'desc')->paginate(6);
                }
 
            }
          



        }
        
        
       
        
        /*

        if ($buscar==''){
            $empleado = Empleado::orderBy('codigo_empleado', 'desc')->paginate(3);
        }
        else{
            $empleado = Empleado::where($criterio, 'like', '%'. $buscar . '%')->orderBy('codigo_empleado', 'desc')->paginate(3);
        }
        
        */
        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados' => $empleados
        ];
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //GUARDAR O REGISTRAR EMPLEADO
    public function store(Request $request)
    {
        try{
                $direccion=new Direccion();
                $direccion_idMax = Direccion::max('id_direccion');
                $id_direccion=$direccion_idMax+1;
                $direccion->id_direccion=$id_direccion;
                $direccion->ubicacion=$request->ubicacion;
                $direccion->numero_vivienda=$request->numero_vivienda;
                $direccion->codigo_municipio=$request->codigo_municipio;
                $direccion->save(); 

                $contactos_telefonicos=new Contactos_Telefonicos();
                $contactos_telefonicos_idMax = Contactos_Telefonicos::max('id_contacto_telefonico');
                $id_contacto_telefonico=$contactos_telefonicos_idMax+1;
                $contactos_telefonicos->id_contacto_telefonico=$id_contacto_telefonico;
                $contactos_telefonicos->numero=$request->numero;
                $contactos_telefonicos->id_tipo_contacto_telefonico=$request->id_tipo_contacto_telefonico;
                $contactos_telefonicos->save();

                $documentos_identificacion=new Documentos_Identificacion();
                $documentos_identificacion_idMax = Documentos_Identificacion::max('numero_documento_identificacion');
                $numero_documento_identificacion=$documentos_identificacion_idMax+1;
                $documentos_identificacion->numero_documento_identificacion=$numero_documento_identificacion;
                $documentos_identificacion->id_tipo_identificacion=$request->id_tipo_identificacion;
                $documentos_identificacion->detalles=$request->detalles;
                $documentos_identificacion->save();

                $empleado=new Empleado();
                $empleado->codigo_empleado='GG2023';
                $empleado->codigo_jefe=$request->codigo_jefe;
                $empleado->primer_nombre =$request->primer_nombre;
                $empleado->segundo_nombre=$request->segundo_nombre;
                $empleado->primer_apellido=$request->primer_apellido;
                $empleado->segundo_apellido=$request->segundo_apellido;
                $empleado->email_personal=$request->email_personal;
                $empleado->email_institucional=$request->email_institucional;
                $empleado->fecha_nacimiento=$request->fecha_nacimiento;
                $empleado->identificador_isss=$request->identificador_isss;
                $empleado->identificador_nup=$request->identificador_nup;
                $empleado->identificador_nit=$request->identificador_nit;
                $empleado->codigo_profesion=$request->codigo_profesion;
                $empleado->id_direccion=$id_direccion;
                $empleado->numero_documento_identificacion=$numero_documento_identificacion;
                $empleado->id_estado_civil=$request->id_estado_civil;
                $empleado->id_genero=$request->id_genero;
                $empleado->id_contacto_telefonico=$id_contacto_telefonico;
            
                /*
                $empleado->condicion='1';
                */
                $empleado->save();

         }
         catch(\Exception $e){
            error_log($e->getMessage());
         }
        
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //ACTUALIZAR EMPLEADO
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleados = Empleado::findOrFail($request->codigo_empleado);
        //$empleado=new Empleado();
        $empleado->primer_nombre =$request->primer_nombre;
        $empleado->segundo_nombre=$request->segundo_nombre;
        $empleado->primer_apellido=$request->primer_apellido;
        $empleado->segundo_apellido=$request->segundo_apellido;
        $empleado->email_personal=$request->email_personal;
        $empleado->email_institucional=$request->email_institucional;
        $empleado->fecha_nacimiento=$request->fecha_nacimiento;
        $empleado->identificador_isss=$request->identificador_isss;
        $empleado->identificador_nup=$request->identificador_nup;
        $empleado->identificador_nit=$request->identificador_nit;
        $empleado->codigo_profesion=$request->codigo_profesion;
        $empleado->id_direccion=$request->id_direccion;
        $empleado->numero_documento_identificacion=$request->numero_documento_identificacion;
        $empleado->id_estado_civil=$request->id_estado_civil;
        $empleado->id_genero=$request->id_genero;
        $empleado->id_contacto_telefonico=$request->id_contacto_telefonico;
        /*
        $empleado->condicion='1';
        */
        $empleado->save();
    }
    /*
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->condicion = '0';
        $empleado->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->condicion = '1';
        $empleado->save();
    }
    */
    //LISTAR EMPLEADOS
    /*
    public function selectEmpleado(Request $request){
        if (!$request->ajax()) return redirect('/');
        $empleados_jefe = Empleado::select('codigo_empleado')->orderBy('codigo_empleado', 'asc')->get();
        return ['empleados_jefe' => $empleados_jefe];
    }
    */
    public function selectEmpleados(Request $request){

        //if (!$request->ajax()) return redirect('/');

        $buscarCodigo = $request->codigo_empleado;
        
        $empleado = Empleado::select('primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido')
                            ->where('codigo_empleado', '=', $buscarCodigo)
                            ->get();
        
        if(!$usuario){
            return ['empleado' => $empleado];
        }else{
            return ['empleado' => $empleado, 'bandera' => '0'];
        }

        
    
    }
    //LISTAR CODIGO DE PROFESIONES
    public function selectProfesion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $profesiones = Profesiones::select('codigo_profesion','titulo')->orderBy('titulo', 'asc')->get();
        return ['profesiones' => $profesiones];
    }
    //LISTAR MUNICIPIOS
    public function selectDireccionMunicipio(Request $request){
        if (!$request->ajax()) return redirect('/');
        $direccion_municipios = Municipio::select('codigo_municipio','nombre')->orderBy('nombre', 'asc')->get();
        return ['direccion_municipios' => $direccion_municipios];
    }
     //LISTAR DEPARTAMENTOS
     public function selectDireccionDepartamento(Request $request){
        if (!$request->ajax()) return redirect('/');
        $direccion_departamentos = Departamento::select('codigo_departamento','nombre')->orderBy('nombre', 'asc')->get();
        return ['direccion_departamentos' => $direccion_departamentos];
    }
     //LISTAR ESTADOS CIVILES
    public function selectEstadoCivil(Request $request){
        if (!$request->ajax()) return redirect('/');
        $Estados_Civiles = Estados_Civiles::select('id_estado_civil','titulo')->orderBy('titulo', 'asc')->get();
        return ['Estados_Civiles' => $Estados_Civiles];
        
    }
    //LISTAR GENEROS
    public function selectGenero(Request $request){
        if (!$request->ajax()) return redirect('/');
        $generos = Generos::select('id_genero','titulo')->orderBy('titulo', 'asc')->get();
        return ['generos' => $generos];
    }
    //LISTAR ID DE CONTACTO TELEFONICO
    public function selectContacto(Request $request){
        if (!$request->ajax()) return redirect('/');
        $contactos = Tipos_Contacto_Telefonico::select('id_tipo_contacto_telefonico','titulo')->orderBy('titulo', 'asc')->get();
        return ['contactos' => $contactos];
    }
    //LISTAR TIPO DE IDENTIFICACION
    public function selectIdentificacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $identificaciones = Tipos_Identificacion::select('id_tipo_identificacion','titulo')->orderBy('titulo', 'asc')->get();
        return ['identificaciones' => $identificaciones];
    }

     //ELIMINAR Empleado
     public function destroy(Request $request)
     {
         if(!$request->ajax()) return redirect('/');
         $empleado = Empleado::findOrFail($request->codigo_empleado);
         $empleado->delete();   
     }
    
}