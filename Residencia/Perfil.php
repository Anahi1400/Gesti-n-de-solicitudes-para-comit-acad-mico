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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
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
            <h2 class="h2">Perfil</h2>
            <ul class="ul" id="ul">
                <li><a href="Menu.php" class="Link">Home</a></li>
                <li><a href="Crear-Solicitud.php" class="Link">Subir Solicitud</a></li>
                <li><a href="Historial_Estudiante.php" class="Link">Historial</a></li>
                <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
            </ul>
        </nav>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <nav>
                    <br>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Datos del Usuario</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Modificar</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent"><br>
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">
                        <div class="center">
                            <div class="col-5"><?php
                                $sql1 = "SELECT Foto FROM estudiante WHERE Id_Estudiante = '$Id'";                                               
                                $consulta1 = mysqli_query($conexion, $sql1);
                                $fila = mysqli_fetch_assoc($consulta1)?> 
                                <img class="imgs" src="<?php echo $fila['Foto'] ;?>" id="imgs">
                            </div>
                    
                            <div class="col-7">
                                <div class="form-group">
                                <?php
                                $sql2 = "SELECT * FROM estudiante WHERE Id_Estudiante = '$Id'";                                               
                                $consulta2 = mysqli_query($conexion, $sql2);
                                while ($fila = mysqli_fetch_assoc($consulta2)):?> 
                                    <label for="Control">No. Control:</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" value="<?php echo $fila['No_Control'] ;?>" disabled>
                                    </div>
                                </div>
                            <div class="form-group">
                                <label for="Nombres">Nombre(s):</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="<?php echo $fila['Nombre']  ;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Apellidos">Apellido Paterno:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="<?php echo $fila['Apellido_Pat'] ;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Apellidos">Apellido Materno:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="<?php echo $fila['Apellido_Mat'] ;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                            <?php
                            $Id_Carrera1 = $fila['Id_Carrera1'];
                            $sql3 = "SELECT NombreCarrera FROM carrera WHERE Id_Carrera = '$Id_Carrera1'";
                            $consulta3 = mysqli_query($conexion, $sql3);
                            $fila3 = mysqli_fetch_assoc($consulta3);?>
                                <label for="Carrera">Carrera:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="<?php echo $fila3['NombreCarrera'] ;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Semestre">Semestre:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="<?php echo $fila['Semestre'] ;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Correo">Correo Institucional:</label>
                                <div class="col-7">
                                    <input type="email" class="form-control" value="<?php echo $User ;?>" disabled>
                                    <?php endwhile ;?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                        tabindex="0">
                        <form action="Cambio_contrasena.php" method="POST">
                            <div class="form-group">
                                <label for="contrasena_actual">Contraseña Actual:</label>
                                <div class="col-7">
                                    <input type="password" class="form-control" name="contrasena_actual" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nueva_contrasena">Nueva Contraseña:</label>
                                <div class="col-7">
                                    <input type="password" class="form-control" name="nueva_contrasena" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                                <div class="col-7">
                                    <input type="password" class="form-control" name="confirmar_contrasena" required>
                                </div>
                            </div>
                            <button type="submit" class="btn1">Actualizar</button>
                        </form>
                        <br><center>No tiene acceso para editar otros datos.</center>
                        <center>Favor de contactar al Jefe de Carrera</center>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula y un número.',
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
                position: 'center',
                icon: 'success',
                title: 'Cambio de contraseña con éxito',
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
    } elseif (isset($_GET['success']) && $_GET['success'] == 3) {
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'No coinciden las contraseñas',
        })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    } elseif (isset($_GET['success']) && $_GET['success'] == 4) {

        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Incorrecta la contraseña actual',
            })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    }
    ?>   
</body>
</html>
<?php mysqli_close($conexion);?>