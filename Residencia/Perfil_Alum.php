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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Estudiante</title>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <header>
    <nav class="nav-sup">
            <button id="menu" class="menu"><img src="Imagenes/menu-regular-24.png"></button>
            <nav class="nav-2">
                <li class="Usu">
                    <img src="Imagenes/user-regular-24.png">
                    <p class="p"><?php echo $nombreUsuario; ?></p>
                </li>
                <h2 class="h2">Perfil Estudiante</h2>
                <ul class="ul" id="ul">
                <button id="cerrar" class="cerrar"><img src="Imagenes/menu-regular-24.png"></button>
                <li><a href="Solicitudes.php" class="Link">Solicitudes</a></li>
                    <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
                </ul>
            </nav>
    </nav>
    </header>

    <main class="container">
        <?php
            $No_Control = $_GET['No_Control'];
            $sql = "SELECT * FROM estudiante WHERE No_Control = '$No_Control'";
            $consulta = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($consulta) > 0) {
                $fila = mysqli_fetch_assoc($consulta);

                $Id_Carrera1 = $fila['Id_Carrera1'];
                $Id_Estudiante = $fila['Id_Estudiante'];
                $sql2 = "SELECT NombreCarrera FROM carrera WHERE Id_Carrera = '$Id_Carrera1'";
                $consulta2 = mysqli_query($conexion, $sql2);
                $fila2 = mysqli_fetch_assoc($consulta2);
                $carrera = $fila2['NombreCarrera'];

                $sql3 = "SELECT Correo FROM inicio_alum WHERE Id_Usuario = '$Id_Estudiante'";
                $consulta3 = mysqli_query($conexion, $sql3);
                $fila3 = mysqli_fetch_assoc($consulta3);
                ?>
                <section>
                    <h2>Datos del Estudiante</h2>
                    <div class="row">
                        <div class="col-md-6">
                        <img class="imgs" src="<?php echo $fila['Foto'] ;?>" id="imgs">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NoControl">No. Control:</label>
                                <input type="text" class="form-control" id="NoControl" value="<?= $fila['No_Control']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Nombres">Nombre(s):</label>
                                <input type="text" class="form-control" id="Nombres" value="<?= $fila['Nombre']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ApellidoMaterno">Apellido Paterno:</label>
                                <input type="text" class="form-control" id="ApellidoPaterno" value="<?= $fila['Apellido_Pat']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ApellidoPaterno">Apellido Materno:</label>
                                <input type="text" class="form-control" id="ApellidoMaterno" value="<?= $fila['Apellido_Mat']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Carrera">Carrera:</label>
                                <input type="text" class="form-control" id="Carrera" value="<?= $carrera; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Semestre">Semestre:</label>
                                <input type="text" class="form-control" id="Semestre" value="<?= $fila['Semestre']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Correo">Correo Institucional:</label>
                                <input type="email" class="form-control" id="Correo" value="<?= $fila3['Correo']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            } else {
                echo '<p>No se encontraron datos para el ID proporcionado.</p>';
            }
        ?>
    </main>

    <footer class="footer">
        <div class="container">
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <img alt="" src="Imagenes/Innovación.png" height="100px" alt="" />
                </div>
                <div class="col-sm-4">
                    <img alt="" src="Imagenes/Jalisco.png" height="100" alt="" />
                </div>
                <div class="col-sm-4">
                    <img alt="" src="Imagenes/tecmm.png" height="130" alt="" />
                </div>
            </div>
        </div>
    </footer>

    <script src="Perfil.js"></script>
</body>
</html>
<?php mysqli_close($conexion);?>