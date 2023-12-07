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
    <title>Historial de Solicitudes</title>
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
                <h2 class="h2">Historial de Solicitudes</h2>
                <ul class="ul" id="ul">
                <button id="cerrar" class="cerrar"><img src="Imagenes/menu-regular-24.png"></button>
                    <li><a href="Menu.php" class="Link">Home</a></li>
                    <li><a href="Perfil.php" class="Link">Perfil</a></li>
                    <li><a href="Crear-Solicitud.php" class="Link">Subir Solicitud</a></li>
                    <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
                </ul>
            </nav>
    </nav>
    <center>
        <br>
        <h2>Historial</h2>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Comentarios Alumno</th>
                            <th scope="col">Comentarios comité</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php
                        $consulta = mysqli_query($conexion, "SELECT s.*, es.* FROM solicitudes s
                        INNER JOIN estudiante_solicitud es ON s.Id_Solicitud = es.Id_Solicitud
                        WHERE es.Id_Estudiante = $Id"); 
                        while ($fila = mysqli_fetch_assoc($consulta)):
                            $Id = $fila['Id_Solicitud'];
                            $Respuesta = basename($fila['Respuesta'])?>
                        <tr>
                            <td><?php echo $fila['Fecha'] ;?></td><?php
                                $estatus = $fila['Estatus'];
                                $imagenEstatus = '';

                                switch ($estatus) {
                                    case 'Pendiente':
                                        $imagenEstatus = 'Imagenes/time-regular-24.png';
                                        break;
                                    case 'Aprobado':
                                        $imagenEstatus = 'Imagenes/check-regular-24.png';
                                        break;
                                    case 'Rechazado':
                                        $imagenEstatus = 'Imagenes/x-regular-24.png';
                                        break;
                                }
                                ?>

                            <td><img src="<?php echo $imagenEstatus; ?>"></td>
                            <td><?php echo $fila['Comentarios'] ;?></td>
                            <td><?php echo $fila['ComentariosAdmin'] ;?></td>
                            <td><?php echo $Respuesta ;?></td><?php
                            $Activo = $fila['Lote'];
                            $sql = mysqli_query($conexion, "SELECT * FROM lotes WHERE Id_Lote = '$Activo'");
                            $fila2 = mysqli_fetch_assoc($sql);?>
                            <td><?php echo $fila2['Lote'] ;?></td>
                            <td><a href="DetallesSolicitud.php?Id=<?php echo $fila['Id_Solicitud']; ?>">Ver detalles</a></td>
                            <?php endwhile ;?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
    <script src="main.js"></script>
</body>
</html>
<?php mysqli_close($conexion);?>