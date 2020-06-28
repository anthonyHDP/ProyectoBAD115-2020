
<?php

$conexion=mysqli_connect('localhost','root','','bdclinica');

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reporte-Boleta-Pago</title>

<style type="text/css">

  hr {
      border-color: #66BDA9;
      height: 1px;
      margin: 5px 0;
      display: block;
      clear: both;
  }

  table {
        border: #CC5A6A 1px solid;

  }

  th,tr,td{
        border: #66BDA9 1px solid;
  }

</style>
</head>
<body>
<header class="clearfix">
  <div id="logo">
    <img src="..\public\img\Pdf.png" width="100" height="100">
  </div>
  <h2 align="center"><font color="#66BDA9">DAEHT - Reporte de Boleta de Pago</font></h2>
  
  <div id="project">
    <hr>
    <div><span>Direccion:</span> Ciudad Merliot, La Libertad</div>
    <div><span>Telefono:</span> 2531-2078</div>
    <div><span>Horario:</span> Lunes a viernes de 7:30 am a 5:30 pm </div>
    
    <hr>
    <br><br>
    
  </div>
</header>
<main>
  <table align="center" >
    <thead>
      <tr>
        <th class="nombre del paciente" bgcolor="#D0D3D4">Nombres/ Apellidos del Paciente</th>
        <th class="tipo de consulta" bgcolor="#D0D3D4">Tipo de Consulta</th>
        <th class="fecha de la cita" bgcolor="#D0D3D4">Fecha de la Cita</th>
        <th class="fecha de la cita" bgcolor="#D0D3D4">Hora de la Cita</th>
        
      </tr>

    </thead>
    <tbody>

      <?php 
      $sql="SELECT * from cita";
      $result=mysqli_query($conexion,$sql);

      while($mostrar=mysqli_fetch_array($result)){
          ?>

      <tr>
        <td class="nombre del paciente"><div align="left"><?php echo $mostrar ['nombrePaciente']?></div></td>
        <td class="tipo de consulta"><div align="left"><?php echo $mostrar ['tipoCita']?></div></td></td>
        <td class="fecha de la cita"><div align="left"><?php echo $mostrar ['fechaCita']?></div></td></td>
        <td class="Hora de la cita"><div align="left"><?php echo $mostrar ['horaCita']?></div></td></td>
        
      </tr>
      <?php
    }
    ?>
    </tbody>
  </table>
  
</main>
<footer>
  <br><br>
  <hr>
  <br>
  <center>Clama a mi y yo te respondere Jeremias 33:3.</center>
</footer>
</body>
</html>