<?php 

    include('Bd.php');
    

    //Registrar Usuario
    if(isset($_POST['Registrar'])){

        $Control = $_POST['numero'];
        $Nombre = $_POST['nombre'];
        $Materno = $_POST['materno'];
        $Paterno = $_POST['paterno'];
        $Semestre = $_POST['semestre'];
        $Carrera = $_POST['carrera'];
        $Correo = $_POST['correo'];
        $Pass = $_POST['password'];
        $Pass2 = $_POST['password2'];
        $Foto = basename($_FILES["foto"]["name"]);
        $Destino = "FotosAlumnos/";
        $urlF = $Destino.$_FILES["foto"]["name"];
        $user = "SELECT Id_Estudiante FROM estudiante WHERE No_Control = '$Control'";
        $user1 = $conexion->query($user);
        
        $Fila = $user1->num_rows;

        $regex = '/^[a-zA-Z0-9._-]+@([a-zA-Z0-9]+)\.(tecmm)\.(edu)\.(mx)$/';

        if($Fila > 0){
            header("location: Inicio_Alum.php?success=5");
            exit();
        }elseif (!preg_match($regex, $Correo)) { 
            header("location: Inicio_Alum.php?success=6");
            exit();
        }else{

            if(strlen($Pass) < 8 || !preg_match('/[A-Z]/', $Pass) || !preg_match('/[0-9]/', $Pass)){
                header("location: Inicio_Alum.php?success=7");
                exit();
            }

            if ($Pass != $Pass2) {
                header("location: Inicio_Alum.php?success=8");
                exit();
            } else {
                $Pass_Encriptada = password_hash($Pass,PASSWORD_DEFAULT);
            }
            
            if (file_exists($_FILES["foto"]["tmp_name"])){   
                if(move_uploaded_file($_FILES["foto"]["tmp_name"], $Destino.$Foto)){   
                    
                    //Cuando se va a realizar la verificación del correo se descomenta el include("verificación.php");
                    include("Verificación.php");

                    if($enviado){

                        //insertar información del usuario
                        $sql = "INSERT INTO estudiante (No_Control, Nombre, Apellido_Mat, Apellido_Pat, Semestre, Foto, Id_Carrera1) 
                        VALUES ( '$Control', '$Nombre', '$Materno','$Paterno','$Semestre','$urlF','$Carrera')";
                        $resultado = mysqli_query($conexion, $sql);

                        $sql2 = "INSERT INTO inicio_alum (Correo, password, codigo_verificacion, email_verificado) VALUES ( '$Correo', '$Pass_Encriptada', '$codigo', 'no')";
                        //$sql2 = "INSERT INTO inicio_alum (Correo, password) VALUES ( '$Correo', '$Pass_Encriptada')";
                        $resultado2 = mysqli_query($conexion, $sql2); 
                        if ($resultado2) {
                            include("Inicio_Alum.php");?>
                            <script>
                                Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Usuario registrado con éxito. Se ha enviado un correo de verificación.',
                                showConfirmButton: false,
                                timer: 5000
                                })
                            </script>
                            <script>
                                setTimeout(() => {
                                    window.history.replaceState(null, null, window.location.pathname);
                                }, 0);
                            </script>
                            <?php
                        } else {
                            include("Inicio_Alum.php");?>
                            <script>
                                Swal.fire({
                                icon: 'error',
                                title: 'Error al registrar usuario',
                                })
                            </script>
                            <script>
                                setTimeout(() => {
                                    window.history.replaceState(null, null, window.location.pathname);
                                }, 0);
                            </script>
                            <?php
                        } 
                    }   
                }
            }        
        } 
    }
?>    