<?php 

    include('Bd.php');
    

    //Registrar Administrador
    if(isset($_POST['Registrar1'])){
        $Nombre = $_POST['nombre'];
        $Apellidos = $_POST['apellidos'];
        $Correo = $_POST['correo'];
        $Pass = $_POST['password'];
        $Pass2 = $_POST['password2'];
        $Pass_Encriptada = password_hash($Pass,PASSWORD_DEFAULT);
        $user = "SELECT Id_Admin FROM inicio_admin WHERE Correo = '$Correo'";
        $user1 = $conexion->query($user);
        
        $Fila = $user1->num_rows;
        $regex = '/^[a-zA-Z0-9._-]+@([a-zA-Z0-9]+)\.(tecmm)\.(edu)\.(mx)$/';

        if($Fila > 0){
            header("location: Solicitudes.php?success=1");
            exit();
        } elseif (!preg_match($regex, $Correo)) { 
            header("location: Solicitudes.php?success=2"); 
            exit();
        } else {

            if(strlen($Pass) < 8 || !preg_match('/[A-Z]/', $Pass) || !preg_match('/[0-9]/', $Pass)){
                header("location: Solicitudes.php?success=3");
                exit();
            }

            if ($Pass != $Pass2) {
                header("location: Solicitudes.php?success=4");
                exit();
            } else {
                $Pass_Encriptada = password_hash($Pass,PASSWORD_DEFAULT);

                //insertar información del Administrador
                $sql = "INSERT INTO administrador (Nombre, Apellidos) VALUES ('$Nombre', '$Apellidos')";
                $resultado = mysqli_query($conexion, $sql);

                $sql2 = "INSERT INTO inicio_admin (Correo, password) VALUES ( '$Correo', '$Pass_Encriptada')";
                $resultado2 = mysqli_query($conexion, $sql2);  
                if ($resultado2) {
                    header("location: Solicitudes.php?success=5");
                    exit();
                } else {
                    header("location: Solicitudes.php?success=6");
                    exit();
                }         
            }
        } 
    }
mysqli_close($conexion);
?>