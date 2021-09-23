<?php

//conectando a la base de datos
$host="localhost";
$bd="sitio";
$usuario="root";
$password="";

try {
    
    $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario,$password);
    


} catch (Exception $ex) {
   echo $ex->getMessage();
}

?>