<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boleta de Pago</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
<header class="clearfix">
  <div id="logo">
    <img src="..\public\img\logo.png" width="100" height="100">
  </div>
  <h1 align="center"><font color="#66BDA9">DAEHT SYSTEM - Reporte de Boleta de Pago de Empleados</font></h1>
  
  <div id="project">
    <hr>
    <div><span>Direccion:</span> Ciudad Merliot, La Libertad</div>
    <div><span>Telefono:</span> 2531-2078</div>
    <div><span>Horario:</span> Lunes a viernes de 7:30 pm a 5:30 pm </div>
    
    <hr>
    <br><br>
    
  </div>
</header>
    
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Código empleado</th>
                    <th>Nombre de usuario</th>
                    <th>Rol Asignado</th>
                    <th>Activo</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $a)
                <tr>
                    <td>{{$a->id_usuario}}</td>
                    <td>{{$a->username}}</td>
                    <td>{{$a->nombre_rol}}</td>
                    <td>{{$a->condicion?'Activo':'Desactivado'}}</td>
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
    
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div> 
    <div>
       <p> <span class="derecha">{{now()}}</span></p>
      
    </div>
</body>
</html>