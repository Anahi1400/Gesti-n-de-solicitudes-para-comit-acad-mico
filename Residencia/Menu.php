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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="Menu" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Menú Principal </title>
    <link rel="stylesheet" href="Css/Estilo_menu.css">
</head>
<body>
    <nav class="nav">
        <ul class="list">
            <div class="list_Button">
                <li class="Link"><img src="Imagenes/user-regular-24.png">
                    <p><?php echo $nombreUsuario; ?></p>
                </li>
            </div>
            <li class="list_Button">
                <div class="imagen">
                    <img src="Imagenes/file-doc-solid-24.png">
                    <a href="Crear-Solicitud.php" class="Link">Subir Solicitud</a>
                </div>
            </li>

            <li class="list_Button">
                <div class="imagen">
                    <img src="Imagenes/folder-open-solid-24.png">
                    <a href="Historial_Estudiante.php" class="Link">Historial</a>
                </div>
            </li>

            <li class="list_Button">
                <div class="imagen">
                    <img src="Imagenes/user-circle-regular-24.png">
                    <a href="Perfil.php" class="Link">Perfil</a>
                </div>
            </li>
            <li class="list_Button">
                <div class="imagen">
                    <img src="Imagenes/log-out-regular-24.png">
                    <a href="Logout.php" class="Link">Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </nav>
    
    <div class="Title">
        <h1>Bienvenido</h1>
    </div>
</body>
</html>
<?php mysqli_close($conexion);?>