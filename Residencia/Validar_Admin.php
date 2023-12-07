<?php 
    session_start();
    include('Bd.php');
    error_reporting(0);

    // Inicio de sesión del estudiante
    $Usuario = $_POST['Email'];
    $password = $_POST['password'];
    $_SESSION['Usuario']= $Usuario;
    
    // Conexion con la tabla inicio_alum
    $sql = "SELECT password FROM inicio_admin WHERE Correo = '$Usuario'";
    $consulta = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($consulta) > 0) {
        $fila = mysqli_fetch_array($consulta);
        $Pass_Hash = $fila['password'];

        $Resultado = password_verify($password,$Pass_Hash);
    
        // Validación del ingreso correcto de los datos
        if($Resultado){
    
            $_SESSION['logueado']= true;
            header("location:Solicitudes.php");
        
        }else{
            $_SESSION['logueado']= false;
            header("location: Inicio_Admin.php?success=1");
            exit(); 
        }
    } else {
        // El correo no existe en la base de datos
        $_SESSION['logueado']= false;
        header("location: Inicio_Admin.php?success=2");
        exit();
    }    
    mysqli_free_result($consulta);
    mysqli_close($conexion);
    ?>