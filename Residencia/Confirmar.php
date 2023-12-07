<?php 
include('Bd.php');
error_reporting(0);

if(isset($_GET['correo'] )){
    $email = $_GET['correo'] ;
}
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificar</title>
        <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
        <link rel="stylesheet" href="Css/Estilos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
            <center> 
                <div class="formulario-crear">
                <h2>verificar cuenta</h2>
                    <form action="Verificar.php" method="POST">
                    <label for="c" class="form-label">Código de Verificación</label>
                        <input type="number" class="form-control" id="c" name="codigo">
                        <input type="hidden" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                        <button type="submit" class="btn btn-primary">Verificar</button>
                    </form>
                </div>
            </center>
            <?php
        mysqli_close($conexion);
        ?>
    </body>
</html>

<?php
    if (isset($_GET['success']) && $_GET['success'] == 2) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'código invalido',
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