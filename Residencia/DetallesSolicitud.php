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
    $Id = $fila['Id_Usuario']; 
    $_SESSION['Id_Usuario'] = $Id;

    // Realizar una consulta para obtener el nombre del usuario
    $Nombre = "SELECT Nombre FROM estudiante WHERE Id_Estudiante = $Id";
    $resultado = mysqli_query($conexion, $Nombre);
    $fila = mysqli_fetch_assoc($resultado);
    $nombreUsuario = $fila['Nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="nav-sup">
        <button id="menu" class="menu"><img src="Imagenes/menu-regular-24.png"></button>
        <nav class="nav-2">
            <li class="Usu">
                <img src="Imagenes/user-regular-24.png">
                <p class="p"><?php echo $nombreUsuario; ?></p>
            </li>
            <h2 class="h2">Detalles de la Solicitud</h2>
            <ul class="ul" id="ul">
                <li><a href="Menu.php" class="Link">Home</a></li>
                <li><a href="Perfil.php" class="Link">Perfil</a></li>
                <li><a href="Crear-Solicitud.php" class="Link">Subir Solicitud</a></li>
                <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
            </ul>
        </nav>
    </nav>
    <main class="container">
        <section>
            <br><h2 style="text-align:center">Detalles de la Solicitud</h2><br>
        </section>
        <section>
        <?php

    if(isset($_GET['Id']) && is_numeric($_GET['Id'])) {
        $Id_Solicitud = $_GET['Id'];

        // Consulta para obtener los detalles de la solicitud
        $Consulta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE Id_Solicitud = $Id_Solicitud");
        
        if(mysqli_num_rows($Consulta) > 0) {
            $fila = mysqli_fetch_assoc($Consulta);?>
            <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Fecha: </h5>
                        <input type="text" class="form-control tamano" id="Fecha" value="<?= $fila['Fecha']; ?>" disabled>
                        <h5>Estatus: </h5>
                        <input type="text" class="form-control tamano" id="Fecha" value="<?php echo $fila['Estatus']?>" disabled>
                    </div>                
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="text-align:center">
                        <h5>Comentarios Estudiante: </h5>
                        <textarea class="form-control" id="Comen" rows="4" disabled><?= $fila['Comentarios']; ?></textarea>
                    </div>                
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Petición: </h5><?php
                        $Petición = basename($fila['Petición']);
                        echo '<a href="' . $fila['Petición'] . '" target="_blank">' . $Petición . '</a>';?>
                        <h5>Evidencias: </h5><?php
                        $Evidencias = basename($fila['Evidencias']);
                        echo '<a href="' . $fila['Evidencias'] . '" target="_blank">' . $Evidencias . '</a>';?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="text-align:center">
                        <h5>Comentarios Comité: </h5>
                        <textarea class="form-control" id="Comen" rows="4" disabled><?= $fila['ComentariosAdmin']; ?></textarea>
                    </div>                
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Respuesta del instituto: </h5><?php
                        $Respuesta = basename($fila['Respuesta']);
                        echo '<a href="' . $fila['Respuesta'] . '" target="_blank">' . $Respuesta . '</a>';?>
                    </div>
                </div>
            </div>
            </form>
            <?php
        } else {
            echo "<p>No se encontraron detalles para la solicitud con Id $Id_Solicitud.</p>";
        }
    } else {
        echo "<p>Error: Id de solicitud no válido.</p>";
    }

    mysqli_close($conexion);
    ?>
                </section>
    </main>
    

    </center>
    <footer class="footer">
        <div class="container">
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
    </footer>
    <script src="Contador.js"></script>
</body>
</html>