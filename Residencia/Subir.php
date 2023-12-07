<?php
    session_start();
    include('Bd.php');
    error_reporting(0);

    // Verifica si ya hay una sesión activa
    if (!isset($_SESSION['Usuario'])) {
        header('Location: Inicio_Alum.php');
        exit();
    }

    $User = $_SESSION['Usuario'];

    $sql = "SELECT Id_Usuario FROM inicio_alum WHERE Correo = '$User'";
    $consulta = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_array($consulta);
    $Id = $fila['Id_Usuario']; 
    $_SESSION['Id_Usuario'] = $Id;

// Comprobar si se ha cargado un archivo
if (isset($_POST['Guardar'])) {
    $Comentarios = $_POST['Comentarios'];
    $Estatus = "Pendiente";
    $NombreA = basename($_FILES["Archivo"]["name"]);
    $NombreI = basename($_FILES["imagen"]["name"]);
    $Destino = "ArchivosPdf/";
    $urlA = $Destino.$_FILES["Archivo"]["name"];
    $urlI = $Destino.$_FILES["imagen"]["name"];
    

    // Mover el archivo a la carpeta de destino
    if (file_exists($_FILES["Archivo"]["tmp_name"])){    
        if (file_exists($_FILES["imagen"]["tmp_name"])){   
            if(move_uploaded_file($_FILES["Archivo"]["tmp_name"], $Destino.$NombreA)){    
                if(move_uploaded_file($_FILES["imagen"]["tmp_name"], $Destino.$NombreI)){

                    // Insertar la información del archivo en la base de datos
                    $sql = "INSERT INTO solicitudes (Petición, Evidencias, Comentarios, Estatus) 
                    VALUES ( '$urlA', '$urlI', '$Comentarios','$Estatus')";
                    $resultado = mysqli_query($conexion, $sql);

                    // Seleccionar el Id de la solicitud
                    $IdSol = mysqli_insert_id($conexion);

                    if (!empty($IdSol)) {

                        // Insertar en la tabla estudiante_solicitud el Id de estudiante y Id de solicitud
                        $sqli = "INSERT INTO estudiante_solicitud (Id_Estudiante, Id_Solicitud) 
                        VALUES ('$Id', '$IdSol')";
                        $res = mysqli_query($conexion, $sqli);
                    }
                    if ($resultado) {
                        header("location: Crear-Solicitud.php?success=1");
                        exit();
                    } else {
                        header("location: Crear-Solicitud.php?success=2");
                        exit();
                    }
                }
            }
        }else{
            if(move_uploaded_file($_FILES["Archivo"]["tmp_name"], $Destino.$NombreA)){

                // Insertar la información del archivo en la base de datos
                $sql = "INSERT INTO solicitudes (Petición, Comentarios, Estatus) 
                VALUES ( '$urlA', '$Comentarios','$Estatus')";
                $resultado = mysqli_query($conexion, $sql);

                // Seleccionar el Id de la solicitud
                $IdSol = mysqli_insert_id($conexion);

                    if (!empty($IdSol)) {

                        // Insertar en la tabla estudiante_solicitud el Id de estudiante y Id de solicitud
                        $sqli = "INSERT INTO estudiante_solicitud (Id_Estudiante, Id_Solicitud) 
                        VALUES ('$Id', '$IdSol')";
                        $res = mysqli_query($conexion, $sqli);
                    }
                if ($resultado) {
                    header("location: Crear-Solicitud.php?success=1");
                    exit();
                } else {
                    header("location: Crear-Solicitud.php?success=2");
                    exit();
                }
            }    
        }
    }else{
        header("location: Crear-Solicitud.php?success=3");
        exit();
    }
}
mysqli_free_result($consulta);
mysqli_close($conexion);
?>