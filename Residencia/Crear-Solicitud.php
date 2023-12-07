<?php 
    session_start();
    include('Bd.php');
    error_reporting(0);

    // Verifica si ya hay una sesión activa
    if (!isset($_SESSION['Usuario'])) {
        header('Location: Inicio_Alum.php');
        exit();
    }

    // Obtener Id_Usuario del Usuario
    $User = $_SESSION['Usuario'];

    $sql = "SELECT Id_Usuario FROM inicio_alum WHERE Correo = '$User'";
    $consulta = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_array($consulta);
    $Id_Usuario = $fila['Id_Usuario']; 
    $_SESSION['Id_Usuario'] = $Id_Usuario;

    // Realizar una consulta para obtener el nombre del usuario
    $Nombre = "SELECT Nombre FROM estudiante WHERE Id_Estudiante = $Id_Usuario";
    $resultado = mysqli_query($conexion, $Nombre);
    $fila = mysqli_fetch_assoc($resultado);
    $nombreUsuario = $fila['Nombre'];

    // Obtener la fecha límite actual desde la base de datos
    $sqlFechaLimite = "SELECT Fecha_Limite FROM configuracion WHERE Id_Fecha = 1";
    $resultadoFechaLimite = mysqli_query($conexion, $sqlFechaLimite);
    $filaFechaLimite = mysqli_fetch_assoc($resultadoFechaLimite);
    $fechaLimite = strtotime($filaFechaLimite['Fecha_Limite']);

    // Comprobar si la fecha actual es posterior a la fecha límite
    $mostrarPagina = (time() < $fechaLimite);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Solicitud</title>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="nav-sup">
        <button id="menu" class="menu"><img src="Imagenes/menu-regular-24.png"></button>
        <nav class="nav-2">   
            <li class="Usu">
                <img src="Imagenes/user-regular-24.png">
                <p class="p"><?php echo $nombreUsuario; ?></p></li>   
            <h2 class="h2">Subir Solicitud</h2>
            <ul class="ul" id="ul">
                <li><a href="Menu.php" class="Link">Home</a></li>
                <li><a href="Perfil.php" class="Link">Perfil</a></li>
                <li><a href="Historial_Estudiante.php" class="Link">Historial</a></li>
                <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
            </ul>
        </nav>
    </nav>
    <?php
    if ($mostrarPagina) { ?>
        <center>
        <?php
            $consulta = mysqli_query($conexion, "SELECT Fecha_Limite FROM configuracion WHERE Id_Fecha = 1");
            $fila = mysqli_fetch_assoc($consulta);
            $fechaLimite = $fila['Fecha_Limite'];
            $fechaLimite1 = date('d-m-y', strtotime($fechaLimite));?> 

            <h6 style="text-align:left">Despues de la fecha no podrás subir una solicitud:</h6>
            
            <?php echo '<h6 style="text-align:left">' . $fechaLimite1 . '</h6>';?>

            <div class="formulario-crear">
            <h2>Subir solicitud</h2>
                <form action="Subir.php" method="POST" enctype="multipart/form-data">
                    <br><label>Ingresar documento en pdf con la solicitud: </label><br>
                    <input type="file" class="form" id="Archivo" name="Archivo" accept=".pdf"><br>
                    <label>Ingresa tus evidencias: </label><br>
                    <input type="file" class="form" id="imagen" name="imagen" accept=".pdf"><br>
                    <label>Comentarios:</label>
                    <label id="Contador">0/200</label>
                    <textarea maxlength="200" id="Comentarios" name="Comentarios"></textarea>
                    <center>
                        <input type="submit" class="btn2" name="Guardar" value="Guardar"><br><br>
                    </center>
                </form>
            </div>
        </center>
        <footer class="footer">
            <div class="container1">
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <img alt="" src="Imagenes/Innovación.png" height="100px" alt=""/>
                    </div>
                    <div class="col-sm-4">
                        <img alt=""  src="Imagenes/Jalisco.png" height="100" alt=""/>
                    </div>
                    <div class="col-sm-4">
                        <img alt="" src="Imagenes/tecmm.png" height="130" alt=""/>
                    </div>
                </div>
            </div>
        </footer><?php
    } else { ?>
        <!-- Mostrar un mensaje de que la página no está disponible -->
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "No se aceptan mas solicitudes fuera de fecha límite",
                    imageUrl: "Imagenes/Error.png",
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: "Custom image"
                });
            </script>
            <?php
    }

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Archivo Subido con éxito',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    } elseif (isset($_GET['success']) && $_GET['success'] == 2) {
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'error al subir el archivo',
        })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    } elseif (isset($_GET['success']) && $_GET['success'] == 3) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'error no se ingreso una solicitud',
            })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    }
    mysqli_close($conexion);
    ?>
    <script src="Contador.js"></script>
</body>
</html>