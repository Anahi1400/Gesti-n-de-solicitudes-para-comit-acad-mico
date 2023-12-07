<?php 
    // Conexión con la base de datos
    $host='127.0.0.1:3308';
    $user='root';
    $pass='';
    $db='gestion_solicitudes';

    $conexion=mysqli_connect($host,$user,$pass,$db);

    if($conexion->connect_error){
        die("No se a podido realizar la conexión a la base de datos, el error fue: ".$conexion->connect_error); 
    }
?>