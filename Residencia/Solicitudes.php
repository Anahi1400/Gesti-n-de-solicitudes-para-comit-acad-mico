<?php
session_start();
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<nav class="nav-sup">
            <button id="menu" class="menu"><img src="Imagenes/menu-regular-24.png"></button>
            <nav class="nav-2">
                <li class="Usu">
                    <img src="Imagenes/user-regular-24.png">
                    <p class="p"><?php echo $nombreUsuario; ?></p>
                </li>
                <h2 class="h2">Solicitudes</h2>
                <ul class="ul" id="ul">
                <button id="cerrar" class="cerrar"><img src="Imagenes/menu-regular-24.png"></button>
                    <li><a href="HistorialGeneral.php" class="Link">Historial</a></li>
                    <li><a href="Logout.php" class="Link"><img src="Imagenes/log-out-regular-24.png"></a></li>
                </ul>
            </nav>
    </nav>
    <main class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>Registrar nuevo administrador:</h5>
                    <button type="button" class="btn2" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">nuevo Admin</button><br><br>
                    <form method="POST" action="" id="formularioActualizacion">
                        <h5>Nuevo Lote:</h5>
                        <input type="text" class="form-control" name="Lote" id="Lote" value=""><br>
                        <button type="button" onclick="confirmarActualizar()" name="action" value="Actualizar" class="btn2">Actualizar</button>
                        <button type="submit" name="action" value="Cerrar" class="btn2">cerrar Lote</button>
                    </form>
                </div>           
            </div>
            <div class="col-md-6">
                <div class="form-group" >
                    <form method="POST" action="">
                        <div class="mb-3">
                            <?php
                            $fechaLimite1 = "";
                            $consulta = mysqli_query($conexion, "SELECT Fecha_Limite FROM configuracion WHERE Id_Fecha = 1");

                            if ($consulta && mysqli_num_rows($consulta) > 0) {
                                $fila = mysqli_fetch_assoc($consulta);
                                $fechaLimite = $fila['Fecha_Limite'];
                                $fechaLimite1 = date('d-m-y', strtotime($fechaLimite)); 
                            }?>

                            <div class="row">
                                <div class="col-md-6">
                                    <br><h5>Fecha actual:</h5>
                                    <input type="text" class="form-control" value="<?php echo $fechaLimite1; ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <h5>Cambiar fecha límite de recibir solicitudes: </h5>
                                    <input type="date" class="form-control" name="Fecha" value="">
                                </div>
                            </div>
                            <button type="submit" class="btn4">Cambiar</button>
                        </div> 
                    </form>
                <?php
                //Cerrar Lote
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['action'])) {
                        $action = $_POST['action'];
                        if ($action == 'Cerrar') {
                            // Procesar el cierre del lote
                            $Actualizar = "UPDATE lotes SET Activo = '0' WHERE Activo = '1'";
                            $Res = mysqli_query($conexion, $Actualizar);

                            if ($Res) {?>
                                <script>
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Lote cerrado con éxito',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                </script>
                                <?php
                            }
                        } ?>
                        <script>
                            setTimeout(() => {
                                window.history.replaceState(null, null, window.location.pathname);
                            }, 0);
                        </script><?php
                    }
                }

                // Formulario de crear solicitudes para actualizar la fecha límite
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Fecha'])) {
                    $nuevaFechaLimite = $_POST['Fecha'];

                    if ($consulta && mysqli_num_rows($consulta) > 0) {
                        // Existe un registro, actualizar la fecha
                        $sql = "UPDATE configuracion SET Fecha_Limite = '$nuevaFechaLimite' WHERE Id_Fecha = 1";
                    } else {
                        // No existe un registro, insertar la nueva fecha
                        $sql = "INSERT INTO configuracion (Id_Fecha, Fecha_Limite) VALUES (1, '$nuevaFechaLimite')";
                    }
                    $resultado = mysqli_query($conexion, $sql);
                    if ($resultado) {?>
                    <script>
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Fecha actualizada con éxito',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    </script>
                    <?php
                    } else {?>
                        <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'error al cambiar la fecha',
                        })
                        </script>
                        <?php
                    }?>
                    <script>
                        setTimeout(() => {
                            window.history.replaceState(null, null, window.location.pathname);
                        }, 0);
                    </script><?php

                }?>
                </div>                
            </div>
        </div>
    
    <center>
        <br>
        <h2>Nuevas Solicitudes</h2>
        <div class="container">
            <div class="table-responsive-xl">
                <table class="table table-hover" id="dataTable1" width="100%">
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
                        $consulta = mysqli_query($conexion, "SELECT * FROM solicitudes
                        WHERE Estatus = 'Pendiente'");
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
                                }?>
                                <td><img src="<?php echo $imagenEstatus; ?>"></td>
                                <td><?php echo $fila['Comentarios'] ;?></td><?php
                                $Activo = $fila['Lote'];
                                $sql4 = mysqli_query($conexion, "SELECT Id_Lote,Activo FROM lotes WHERE Id_Lote = '$Activo'");
                                $fila4 = mysqli_fetch_assoc($sql4);
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

    <center>
        <form action="Generar_Excel.php" method="post">
            <button type="submit" class="btn5" name="descargar_excel">Descargar Excel</button>
        </form>
        <h2>Solicitudes Lote Actual</h2>
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
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Traer las solicitudes que son del Lote Actual
                        $consulta = mysqli_query($conexion, "SELECT s.*, l.Id_Lote FROM solicitudes s JOIN lotes l ON s.Lote = l.Id_Lote WHERE l.Activo = 1");

                        while ($fila = mysqli_fetch_assoc($consulta)):
                               ?>
                            <tr>
                                <?php 
                                $Id = $fila['Id_Solicitud'];
                                $sql = mysqli_query($conexion, "SELECT Id_Estudiante FROM estudiante_solicitud WHERE Id_Solicitud = $Id");
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
                                <td><?php echo $fila['Comentarios'] ;?></td>
                                <td><a href="Detalles_Solicitud.php?Id=<?php echo $fila['Id_Solicitud']; ?>">Ver detalles</a></td>
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
    <!-- Alertas -->
    <?php include "AgregarAdmin.php"; 

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'El Usuario ya existe',
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
            title: 'El correo institucional no es válido',
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
            title: 'La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula y un número.',
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
            title: 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo.',
        })
        </script>
        <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
        </script>
        <?php
    } elseif (isset($_GET['success']) && $_GET['success'] == 5) {
        ?>
        <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Usuario registrado con éxito',
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
    } elseif (isset($_GET['success']) && $_GET['success'] == 6) {
        ?>
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
    }?>

    <script>
    function confirmarActualizar() {
        Swal.fire({
            title: "¿Estás seguro de agregar un nuevo lote?",
            text: "Se cerrará el lote anterior.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, estoy seguro",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtener el valor del campo de texto
                var nuevoLote = document.getElementById('Lote').value;
                
                $.ajax({
                    type: 'POST',
                    url: 'ActualizarLote.php',
                    data: { Lote: nuevoLote },
                    success: function (response) {
                        if (response === 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Lote actualizado con éxito',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (response === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al agregar nuevo lote',
                            });
                        } else if (response === 'lote_existente') {
                            Swal.fire({
                                icon: 'error',
                                title: 'El lote ya existe. No se puede agregar.',
                            });
                        } else if (response === 'lote_vacio') {
                            Swal.fire({
                                icon: 'error',
                                title: 'El lote esta vacío. No se puede agregar.',
                            });
                        }
                    }
                });    
            }
        });
    }
</script><?php

    
    mysqli_close($conexion);?>
</body>
</html>