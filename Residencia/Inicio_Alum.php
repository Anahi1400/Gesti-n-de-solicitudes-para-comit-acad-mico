<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="Css/Estilos.css">
</head>
<body>
    <img src="Imagenes/Banner.jpg" class="banner" alt="">
    <h2 class="Banner">Estudiantes</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="formulario">
                    <form action="Inicio_Validar.php" method="post" enctype="multipart/form-data">
                        <br>
                        <h2>Inicio de sesión</h2>
                        <div class="usuario">Usuario</div>
                        <input type="email" class="form-control" name="Email"  placeholder="Ingresa tu correo..." required>
                        <div class="password">Contraseña</div>
                        <input type="password" name="password" class="form-control" required>
                        <input type="submit" class="btn1" name="Iniciar" value="Iniciar" ><br><br>
                        <a href="Inicio_Admin.php" class="LinkUsu">Administrador</a>
                        <button type="button" class="btn3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    </footer>
    <?php include "Agregar.php"; ?>
</body>
</html>

<?php
    include('Bd.php');

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Contraseña Incorrecta.',
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
                title: 'La cuenta no está verificada. Verifica tu correo electrónico.',
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
                position: 'center',
                icon: 'success',
                title: 'Usuario registrado con éxito. ya puede iniciar sesión.',
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
    } elseif (isset($_GET['success']) && $_GET['success'] == 4) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Correo no registrado como estudiante.',
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
    } elseif (isset($_GET['success']) && $_GET['success'] == 6) {

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
        </script><?php
    } elseif (isset($_GET['success']) && $_GET['success'] == 7) {

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
    } elseif (isset($_GET['success']) && $_GET['success'] == 8) {

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
    }
?>