<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Administrador</a></li>
                <li class="breadcrumb-item active">Contratos</li>
            </ol>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Contratos de Trabajo
                        <button type="button" @click="abrirModal('contrato','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarContrato(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarContrato(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código_Contrato</th>
                                    <th>Codigo_Empleado</th>
                                    <th>Fecha_Inicio</th>
                                    <th>Fecha_Fin</th>
                                    <th>Salario</th>
                                    <th>Estado</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in arrayContrato" :key="contrato.id">
                                    <td>
                                        <button type="button" @click="abrirModal('contrato','actualizar',contrato)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="contrato.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarContrato(contrato.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarContrato(contrato.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="contrato.codigo_contrato"></td>
                                    <td v-text="contrato.codigo_empleado"></td>
                                    <td v-text="contrato.fecha_inicio"></td>
                                    <td v-text="contrato.fecha_final"></td>
                                    <td v-text="contrato.salario"></td>
                                    
                                    <td>
                                        <div v-if="contrato.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding:4%">
                           <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Asignacion de Contrato</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Datos Relevantes</a>
                               <!-- <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                                -->
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                  <div v-if="tipoAccion == 1" class="form-group">
                                    <label for="text">Buscar empleado por codigo</label>
                                    <div class="row" style="margin-left:0.45%">
                                        <input v-model="codigo_empleado" maxlength="6" type="text" class="form-control col-md-3" placeholder="Ej. AA1000">
                                        <button id="btn_empleado" @click="selectEmpleado(codigo_empleado)" type="button" class="btn btn-success btn-buscar"><i class="fa fa-search"></i></button>
                                        <input id="empleado_input_e" type="text" class="form-control col-sm-7" style="font-style:italic; margin-left:5.5%; border:0; border-radius:6px; background: #eee" :value="nombres+' '+apellidos+'      '+codigo_empleado_res" disabled>      
                                        <span class="help-block" style="font-size:80%; margin-top:1%">(*) Debe consultar el codigo de empleado y si existe, se asociara ese empleado al contrato</span>
                                    </div>
                                </div>
                                <div v-if="tipoAccion == 2" class="form-group">
                                    <label for="text">Empleado</label>
                                    <input type="text" class="form-control" style="font-style:italic; border:0; border-radius:6px; background: #eee" :value="nombres+' '+apellidos+'      '+codigo_empleado_res" disabled>
                                </div>

                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">


                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo Puesto</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="codigo_puesto">
                                            <option value="0" disabled>Seleccione Puesto</option>
                                            <option v-for="puestos in arrayPuestos" :key="puestos.codigo_puesto" :value="puestos.codigo_puesto" v-text="puestos.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Contrato</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipo" class="form-control" placeholder="Digite el tipo de Contrato">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Inicial de Contrato</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha_inicio" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de Finalizacion de Contrato</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha_final" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Duracion de Contrato</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="duracion" class="form-control" placeholder="Ingrese la duracion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Salario</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="salario" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                 <div class="form-group">
                                            <label for="activo">Vigencia de Contrato</label>
                                            
                                            
                                 </div>


                                </div>
                                <!--
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                                -->
                                </div>
                            </div>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                                         
                                
            
                                <div v-show="errorContrato" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjContrato" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarContrato()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarContrato()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    
    export default {
        data (){
            return {
                codigo_contrato: 0,
                codigo_empleado:'',
                codigo_puesto:0,
                tipo:'',
                fecha_inicio:'',
                fecha_final:'',
                duracion:'',
                salario:'',
                arrayContrato:[],
                arrayEmpleados:[],
                arrayPuestos:[],
                modal : 0,
                tituloModal : '',
                nombres:'',
                apellidos:'',
                tipoAccion : 0,
                errorContrato :0,
                errorContrato:[],
                codigo_empleado_res:'', 
                errorMostrarMsjContrato : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
                
            }
        },
         
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarContrato (page,buscar,criterio){
                let me=this;
                var url= '/Contrato?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayContrato = respuesta.Contratos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEmpleado(){
                let me=this;
                var url= '/empleado/selectEmpleado';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayEmpleado = respuesta.empleados;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPuesto(){
                let me=this;
                var url= '/puesto/selectPuesto';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayPuestos = respuesta.puestos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEmpleado(codigo_empleado){
                let me=this;
                var url= '/empleado/selectEmpleado?codigo_empleado='+codigo_empleado;
                axios.get(url).then(function (response) {
                    var respuesta  = response.data;
                    me.nombres = '';
                    me.apellidos = '';
                    me.codigo_empleado_res = '';
                    console.log("TIPO EMPLEADO[0]: "+ typeof response.data.empleado[0]);
                    console.log("RESPONSE "+response);
                    console.log("DATA: "+response.data);
                    console.log("EMPLEADO: "+response.data.empleado[0]);
                    if(me.tipoAccion == 1){
                        if(response.data.empleado[0] !== null && typeof response.data.empleado[0] !== 'undefined'){
                            console.log('BANDERA: '+response.data.bandera);
                            if(response.data.bandera != 0){
                                me.nombres = respuesta.empleado[0].primer_nombre+" "+respuesta.empleado[0].segundo_nombre;
                                me.apellidos = respuesta.empleado[0].primer_apellido+" "+respuesta.empleado[0].segundo_apellido;
                                me.codigo_empleado_res = codigo_empleado;
                                document.getElementById("empleado_input_e").style.border = "1px solid #ccc";
                            }else{
                                me.nombres = respuesta.empleado[0].primer_nombre+" "+respuesta.empleado[0].segundo_nombre;
                                me.apellidos = respuesta.empleado[0].primer_apellido+" "+respuesta.empleado[0].segundo_apellido;
                                me.codigo_empleado_res = codigo_empleado;
                                document.getElementById("empleado_input_e").style.border = "1px solid #ccc";
                            }
                        } else {
                            console.log("NO EXISTE");
                            //$('#btn_empleado').trigger('click');
                            $('#empleado_input_e').val("El empleado no existe");
                        }
                    } else {
                        me.nombres = respuesta.empleado[0].primer_nombre+" "+respuesta.empleado[0].segundo_nombre;
                        me.apellidos = respuesta.empleado[0].primer_apellido+" "+respuesta.empleado[0].segundo_apellido;
                        me.codigo_empleado_res = codigo_empleado;
                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarContrato(page,buscar,criterio);
            },
            registrarContrato(){
                if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.post('/Contrato/registrar',{
                    //'codigo_contrato': this.codigo_contrato,
                    'codigo_empleado': this.codigo_empleado_res, 
                    'codigo_puesto':this.codigo_puesto,
                    'tipo': this.tipo,
                    'fecha_inicio': this.fecha_inicio.replace("-", "/").replace("-", "/").substring(2, 10),
                    'fecha_final': this.fecha_final.replace("-", "/").replace("-", "/").substring(2, 10),
                    'duracion': this.duracion,
                    'salario':this.salario
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarContrato(){
               if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.put('/Contrato/actualizar',{
                   // 'codigo_contrato': this.codigo_contrato,
                    'codigo_empleado': this.codigo_empleado,
                    'codigo_puesto':this.codigo_puesto,
                    'tipo': this.tipo,
                    'fecha_inicio': this.fecha_inicio,
                    'fecha_final': this.fecha_final,
                    'duracion': this.duracion,
                    'salario':this.salario
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarContrato(id){
               swal({
                title: 'Esta seguro de desactivar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/Contrato/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarContrato(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarContrato(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/Contrato/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarContrato(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarContrato(){
                this.errorContrato=0;
                this.errorMostrarMsjContrato =[];

                if (this.codigo_empleado==0) this.errorMostrarMsjContrato.push("Seleccione el Empleado.");
                if (this.codigo_puesto==0) this.errorMostrarMsjContrato.push("Seleccione el Puesto de Trabajo.");
                if (!this.tipo) this.errorMostrarMsjContrato.push("digite el tipo de Contrato.");
                if (!this.fecha_inicio) this.errorMostrarMsjContrato.push("El contrato necesita la fecha de Inicio.");
                if (!this.fecha_final) this.errorMostrarMsjContrato.push("El contrato necesita la fecha de Finalizacion.");
                if (!this.fecha_final) this.errorMostrarMsjContrato.push("El contrato necesita el Salario correspondiente.");

                if (this.errorMostrarMsjContrato.length) this.errorContrato = 1;

                return this.errorContrato;
            },
            
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.codigo_puesto= '';
                this.codigo_empleado ='';
                this.codigo_contrato ='';
                this.codigo_empleado_res='';
                this.nombres='';
                this.apellidos='';
                this.errorContrato=0;
                if(document.getElementById("empleado_input_e")!=null) document.getElementById("empleado_input_e").value = "";
                if(document.getElementById("empleado_input_e")!=null) document.getElementById("empleado_input_e").style.border = "1px solid #ccc";
                document.getElementById("rol_input_e").style.border = "1px solid #ccc";
                if(document.getElementById("password_input_e")!=null) document.getElementById("password_input_e").style.border = "1px solid #ccc";
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "contrato":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Contrato';
                                this.codigo_empleado='';
                                this.codigo_puesto=0;
                                this.tipo='';
                                this.fecha_inicio='';
                                this.fecha_final= '';
                                this.salario='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Contrato';
                                this.tipoAccion=2;
                                this.codigo_empleado=data['codigo_empleado'];
                                this.codigo_puesto=data['codigo_puesto'];
                                this.tipo=data['tipo'];
                                this.fecha_final = data['fecha_inicial'];
                                this.fecha_final=data['fecha_final'];
                                this.salario=data['salario'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpleado();
                this.selectPuesto();
            }
        },
        mounted() {
            this.listarContrato(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>