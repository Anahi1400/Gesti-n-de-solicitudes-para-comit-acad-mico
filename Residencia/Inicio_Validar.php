<?php 
session_start();
include('Bd.php');
error_reporting(0);

    // Inicio de sesión del estudiante
    $Usuario = $_POST['Email'];
    $password = $_POST['password'];
    $_SESSION['Usuario']= $Usuario;
    
    // Conexion con la tabla inicio_alum
    $sql = "SELECT password, email_verificado FROM inicio_alum WHERE Correo = '$Usuario'";
    $consulta = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($consulta) > 0) {
        $fila = mysqli_fetch_array($consulta);
        $Pass_Hash = $fila['password'];
        $email_verificado = $fila['email_verificado'];

        $Resultado = password_verify($password,$Pass_Hash);

        // Validación del ingreso correcto de los datos
        if($Resultado){

            if ($email_verificado === 'si') {
                $_SESSION['logueado'] = true;
                header("location:Menu.php");
            } else {
                $_SESSION['logueado'] = false;
                header("location: Inicio_Alum.php?success=2");
            }
        }else {
            $_SESSION['logueado'] = false;
            header("location: Inicio_Alum.php?success=1");
        }
    } else {
        // El correo no existe en la base de datos
        $_SESSION['logueado'] = false;
        header("location: Inicio_Alum.php?success=4");
    }       
    mysqli_free_result($consulta);
    mysqli_close($conexion);
    ?>