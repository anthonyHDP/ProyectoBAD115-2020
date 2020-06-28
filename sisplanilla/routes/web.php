<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

    

});
/*
Route::group(['middleware'=>['auth']],function(){
    //Todas las rutas

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['Administrador']], function () {
    //Rutas del administrador
    });

    Route::group(['middleware' => ['Jeferrhh']], function () {
    //Rutas del Jefe de Recursos Humanos
    });

   

});
*/

/*Route::get('/', function () {
    return view('contenido/contenido');
});*/
Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/privilegio', 'PrivilegioController@index');
Route::post('/privilegio/registrar', 'PrivilegioController@store');
Route::put('/privilegio/actualizar', 'PrivilegioController@update');
Route::put('/privilegio/eliminar', 'PrivilegioController@destroy');

Route::get('/rol', 'RolController@index');
Route::post('/rol/registrar', 'RolController@store');
Route::put('/rol/actualizar', 'RolController@update');
Route::put('/rol/eliminar', 'RolController@destroy');

Route::get('/usuario', 'UsuarioController@index');
Route::post('/usuario/registrar', 'UsuarioController@store');
Route::put('/usuario/actualizar', 'UsuarioController@update');
Route::put('/usuario/eliminar', 'UsuarioController@destroy');
Route::get('/rol/selectRoles', 'UsuarioController@selectRoles');
Route::get('/empleado/selectEmpleado', 'UsuarioController@selectEmpleados');

Route::post('/rolprivilegio/registrar', 'Roles_PrivilegiosController@store');

route::get('/usuario/listarPdf','UsuarioController@listarPdf')->name('usuarios_pdf');

//Henry
Route::get('/empleado/selectEmpleado', 'UsuarioController@selectEmpleados');
Route::get('/empleado','EmpleadoController@index');
Route::post('/empleado/registrar','EmpleadoController@store');
Route::put('/empleado/actualizar','EmpleadoController@update');
Route::put('/empleado/desactivar','EmpleadoController@desactivar');
Route::put('/empleado/activar','EmpleadoController@activar');
Route::get('/profesiones/selectProfesion', 'EmpleadoController@selectProfesion');

Route::get('/estados_civiles/selectEstadoCivil', 'EmpleadoController@selectEstadoCivil');
Route::get('/generos/selectGenero', 'EmpleadoController@selectGenero');
Route::get('/contactos_telefonicos/selectContacto', 'EmpleadoController@selectContacto');
Route::get('/direccion_municipio/selectDireccionMunicipio', 'EmpleadoController@selectDireccionMunicipio');
Route::get('/direccion_departamento/selectDireccionDepartamento', 'EmpleadoController@selectDireccionDepartamento');
Route::get('/tipos_identificacion/selectIdentificacion', 'EmpleadoController@selectIdentificacion');
Route::get('/tipo_contacto_telefonico/selectContacto', 'EmpleadoController@selectContacto');
Route::get('/empleados/selectEmpleado', 'EmpleadoController@selectEmpleado');

Route::get('/puesto/selectPuesto','ContratoController@selectPuesto');
Route::get('/empleado/selectEmpleados','ContratoController@selectEmpleado');
Route::post('/contrato','ContratoController@index');
Route::post('/contrato/registrar','ContratoController@store');
Route::put('/contrato/actualizar','ContratoController@update');
Route::put('/contrato/activar','ContratoController@activar');

//Anthony

Route::get('/menu', 'MenuController@index');
Route::post('/menu/registrar', 'MenuController@store');
Route::put('/menu/actualizar', 'MenuController@update');
Route::put('/menu/desactivar', 'MenuController@desactivar');
Route::put('/menu/activar', 'MenuController@activar');
Route::get('/rol/selectRoles', 'RolController@selectRoles');

Route::get('/itemmenu', 'ItemMenuController@index');
Route::post('/itemmenu/registrar', 'ItemMenuController@store');
Route::put('/itemmenu/actualizar', 'ItemMenuController@update');
Route::put('/itemmenu/desactivar', 'ItemMenuController@desactivar');
Route::put('/itemmenu/activar', 'ItemMenuController@activar');
Route::get('/menu/selectMenus', 'MenuController@selectMenus');
Route::get('/itemmenu/selectItemsPadre', 'ItemMenuController@selectItemsPadre');

Route::get('/empresa', 'EmpresaController@index');
Route::post('/empresa/registrar', 'EmpresaController@store');
Route::put('/empresa/actualizar', 'EmpresaController@update');
//Route::put('/empresa/desactivar', 'EmpresaController@desactivar');
//Route::put('/empresa/activar', 'EmpresaController@activar');
Route::get('/direccion/selectDireccion', 'EmpresaController@selectDireccion');