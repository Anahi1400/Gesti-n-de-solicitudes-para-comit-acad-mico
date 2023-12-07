<?php
session_start();
error_reporting(0);
include('Bd.php');

// Verifica si ya hay una sesión activa
if (!isset($_SESSION['Usuario'])) {
    header('Location: Inicio_Admin.php');
    exit();
}

// Obtener Id_Usuario del Admin
$User = $_SESSION['Usuario'];

$sql = "SELECT Id_Admin FROM inicio_admin WHERE Correo = '$User'";
$consulta = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($consulta);
$Id = $fila['Id_Admin']; 
$_SESSION['Id_Admin'] = $Id;

// Realizar una consulta para obtener el nombre del Admin
$Nombre = "SELECT Nombre FROM administrador WHERE Id = $Id";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="nav-sup">
        <button id="menu" class="menu"><img src="Imagenes/menu-regular-24.png"></button>
        <nav class="nav-2">
            <li class="Usu">
                <img src="Imagenes/user-regular-24.png">
                <p class="p"><?php echo $nombreUsuario; ?></p>
            </li>
            <h2 class="h2">Detalles de Solicitudes</h2>
            <ul class="ul" id="ul">
                <button id="cerrar" class="cerrar"><img src="Imagenes/menu-regular-24.png"></button>
                <li><a href="Solicitudes.php" class="Link">Solicitudes</a></li>
                <li><a href="HistorialGeneral.php" class="Link">Historial</a></li>
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
    
    //Validar el Usuario
    $User = $_SESSION['Usuario'];
    $sql = "SELECT Id_Admin FROM inicio_admin WHERE Correo = '$User'";
    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_fetch_array($consulta);
    $IdAdmin = $filas['Id_Admin']; 
    $_SESSION['Id_Admin'] = $IdAdmin;

    //Validar el Id del Lote Activo
    $sql = "SELECT Id_Lote FROM lotes WHERE Activo = '1'";
    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_fetch_array($consulta);
    $Id_Lote = $filas['Id_Lote']; 

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
                        <h5>Comentarios del Alumno: </h5>
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
            <center>
                <br>
                <h2>Solicitudes</h2>
                <div class="container">
                    <table class="table table-bordered" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th>No. Control</th>
                                <th>Nombre</th>
                                <th>carrera</th>
                                <th>Estatus</th>
                                <th>Comentarios</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $Cons = mysqli_query($conexion, "SELECT Id_Estudiante FROM estudiante_solicitud WHERE Id_Solicitud = $Id_Solicitud");
                            $fila = mysqli_fetch_assoc($Cons);
                            $Id_Estudiante = $fila['Id_Estudiante'];
                            $ConsultaDetallesSolicitudes = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE Id_Solicitud IN (SELECT Id_Solicitud FROM estudiante_solicitud WHERE Id_Estudiante = $Id_Estudiante)");



                            while ($filaDetallesSolicitud = mysqli_fetch_assoc($ConsultaDetallesSolicitudes)) {
                                $sql2 = mysqli_query($conexion, "SELECT * FROM estudiante WHERE Id_Estudiante = '$Id_Estudiante'");

                                    while ($fila2 = mysqli_fetch_assoc($sql2)):
                                ?>
                                <tr>
                                        <td><a href="Perfil_Alum.php?No_Control=<?php echo $fila2['No_Control']; ?>"><?php echo $fila2['No_Control']; ?></a></td>
                                        <td><?php echo $fila2['Nombre'] ;?></td>

                                        <?php $Id_Carrera = $fila2['Id_Carrera1'];
                                        $sql3 = mysqli_query($conexion, "SELECT NombreCarrera FROM carrera WHERE Id_Carrera = '$Id_Carrera'");
                                        $fila3 = mysqli_fetch_assoc($sql3);?>
                                    
                                        <td><?php echo $fila3['NombreCarrera'] ;?></td>
                                        <?php
                                    endwhile ;
                                    $estatus = $filaDetallesSolicitud['Estatus'];
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
                                    <td><?php echo $filaDetallesSolicitud['Comentarios']; ?></td>
                                    <?php
                                    $Activo = $filaDetallesSolicitud['Lote'];
                                    $sql4 = mysqli_query($conexion, "SELECT Id_Lote,Activo FROM lotes WHERE Id_Lote = '$Activo'");
                                    $fila4 = mysqli_fetch_assoc($sql4);
                                    if ($fila4 && isset($fila4['Activo'])) {
                                        if ($fila4['Activo'] == 0) {
                                            ?>
                                            <td><a href="Detalles_Solicitud2.php?Id=<?php echo $filaDetallesSolicitud['Id_Solicitud']; ?>">Ver detalles</a></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td><a href="Detalles_Solicitud.php?Id=<?php echo $filaDetallesSolicitud['Id_Solicitud']; ?>">Ver detalles</a></td>
                                            <?php
                                        }
                                    } else {?>
                                        <td><a href="Detalles_Solicitud.php?Id=<?php echo $filaDetallesSolicitud['Id_Solicitud']; ?>">Ver detalles</a></td><?php
                                    }?>
                                </tr>
                             <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </center>
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
    <?php include "AgregarAdmin.php"; ?>
    <script src="Contador.js"></script>
</body>
</html>