<?php
session_start();
include('Bd.php');
error_reporting(0);

if (isset($_SESSION['Usuario']) && isset($_POST['contrasena_actual']) && isset($_POST['nueva_contrasena']) && isset($_POST['confirmar_contrasena'])) {
    $Usuario = $_SESSION['Usuario'];
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    $sql = "SELECT password FROM inicio_alum WHERE Correo = '$Usuario'";
    $consulta = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_array($consulta);
    $Pass_Hash = $fila['password'];

    $Resultado = password_verify($contrasena_actual,$Pass_Hash);

    // Validación del ingreso correcto de los datos
    if($Resultado){
        if(strlen($nueva_contrasena) < 8 || !preg_match('/[A-Z]/', $nueva_contrasena) || !preg_match('/[0-9]/', $nueva_contrasena)){
            header("location: Perfil.php?success=1");
            exit();
        } elseif($nueva_contrasena==$confirmar_contrasena){
            $Pass_Encriptada = password_hash($confirmar_contrasena,PASSWORD_DEFAULT);
            $sql2 = "UPDATE inicio_alum SET password = '$Pass_Encriptada' WHERE Correo = '$Usuario'";
            $resultado2 = mysqli_query($conexion, $sql2);

            if($resultado2){
                header("location: Perfil.php?success=2");
                exit();
            }
        }else{
            header("location: Perfil.php?success=3");
            exit();
        }
    }else{
        header("location: Perfil.php?success=4");
        exit();
    }

}
mysqli_close($conexion);
?>