<?php
session_start();
include('Bd.php');
error_reporting(0);

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
                <h2 class="h2">Historial de Solicitudes</h2>
                <ul class="ul" id="ul">
                <button id="cerrar" class="cerrar"><img src="Imagenes/menu-regular-24.png"></button>
                    <li><a href="Solicitudes.php" class="Link">Solicitudes</a></li>
                    <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
                </ul>
            </nav>
    </nav>
    <main class="container">
    <center>
        <br>
        <h2>Historial de Solicitudes</h2>
        <div class="container">
            <div class="table-responsive-xl">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No. Control</th>
                            <th>Nombre</th>
                            <th>carrera</th>
                            <th>Estatus</th>
                            <th>Comentarios</th>
                            <th>Lote</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('Bd.php');
                        $consulta = mysqli_query($conexion, "SELECT * FROM solicitudes");
                        while ($fila = mysqli_fetch_assoc($consulta)):
                           ?>
                            <tr>
                                <?php 
                                $Id = $fila['Id_Solicitud'];

                                $sql = mysqli_query($conexion, "SELECT Id_Estudiante FROM estudiante_solicitud WHERE    Id_Solicitud = '$Id'");
                                $fila1 = mysqli_fetch_assoc($sql);
                                if (isset($fila1['Id_Estudiante'])) {
                                    $Id_Estudiante = $fila1['Id_Estudiante'];
                        
                                    $sql2 = mysqli_query($conexion, "SELECT * FROM estudiante WHERE Id_Estudiante = '$Id_Estudiante'");

                                    while ($fila2 = mysqli_fetch_assoc($sql2)):?>
                                    
                                        <td><a href="Perfil_Alum.php?No_Control=<?php echo $fila2['No_Control']; ?>"><?php echo $fila2['No_Control']; ?></a></td>
                                        <td><?php echo $fila2['Nombre'] ;?></td>

                                        <?php $Id_Carrera = $fila2['Id_Carrera1'];
                                        $sql3 = mysqli_query($conexion, "SELECT NombreCarrera FROM carrera WHERE Id_Carrera = '$Id_Carrera'");
                                        $fila3 = mysqli_fetch_assoc($sql3);?>
                                        <td><?php echo $fila3['NombreCarrera'] ;?></td><?php
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
                                    endwhile ; 
                                } ?>

                                <td><img src="<?php echo $imagenEstatus; ?>"></td>
                                <td><?php echo $fila['Comentarios'] ;?></td><?php
                                $Activo = $fila['Lote'];
                                $sql4 = mysqli_query($conexion, "SELECT * FROM lotes WHERE Id_Lote = '$Activo'");
                                $fila4 = mysqli_fetch_assoc($sql4);?>
                                <td><?php echo $fila4['Lote'] ;?></td><?php
                                if ($fila4 && isset($fila4['Activo'])) {
                                    if ($fila4['Activo'] == 0) {
                                        ?>
                                        <td><a href="Detalles_Solicitud2.php?Id=<?php echo $fila['Id_Solicitud']; ?>">Ver detalles</a></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td><a href="Detalles_Solicitud.php?Id=<?php echo $fila['Id_Solicitud']; ?>">Ver detalles</a></td>
                                        <?php
                                    }
                                } else {?>
                                    <td><a href="Detalles_Solicitud.php?Id=<?php echo $fila['Id_Solicitud']; ?>">Ver detalles</a></td><?php
                                }?>
                            </tr>
                        <?php endwhile ;?>
                    </tbody>
                </table>
            </div>
        </div>
    </center>
    </main>
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
    <?php include "AgregarAdmin.php"; 
    mysqli_close($conexion);?>
</body>
</html>