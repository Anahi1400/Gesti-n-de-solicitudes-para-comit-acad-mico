<?php
    include('Bd.php');
    error_reporting(0);
    $email =$_POST['email'];
    $codigo =$_POST['codigo'];
    $res = $conexion->query("SELECT * FROM Inicio_Alum WHERE Correo='$email' AND codigo_verificacion='$codigo' ");

    if( mysqli_num_rows($res) > 0 ){
        
        $conexion->query("UPDATE Inicio_Alum SET email_verificado = 'si' WHERE Correo = '$email' ");
        header("location: Inicio_Alum.php?success=3");

    }else{
        header("location: Confirmar.php?correo=$email&success=2");
    }
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar</title>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>