<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
header("location:../index.php");
  
}

else {
  if ($_SESSION["usuario"]=="ok") {
    $nombreUsuario=$_SESSION['nombreUsuario'];
  }
  
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
<!--EL $_SERVER SIRVE PARA REFERENCIAL AL HOST DEL SITIO-->
  <?php $url = 'http://'.$_SERVER['HTTP_HOST'].'/proyectos_complete/sitio_administrativo'?>

      <nav class="navbar navbar-expand navbar-light bg-light">
          <div class="nav navbar-nav">
              <a class="nav-item nav-link active" href="#">administrador <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="<?php echo $url?>/administrador/inicio.php">inicio</a>
              <a class="nav-item nav-link" href="<?php echo $url?>/administrador/seccion/productos.php">libros</a>
              <a class="nav-item nav-link" href="<?php echo $url?>/administrador/seccion/cerrar_seccion.php">cerrar sesion</a>
              <a class="nav-item nav-link" href="<?php echo $url; ?>">ver sitio web</a>
          </div>
      </nav>
      
    <div class="container">
        <div class="row">