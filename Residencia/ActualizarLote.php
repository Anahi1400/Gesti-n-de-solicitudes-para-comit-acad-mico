<?php
include('Bd.php');

if (isset($_POST['Lote'])) {
    $nuevoLote = $_POST['Lote'];

    if (empty($nuevoLote)) {
        // Campo Vacío
        echo 'lote_vacio';
    } else {

        // Verificar si el lote ya existe
        $Existencia = "SELECT * FROM lotes WHERE Lote = '$nuevoLote'";
        $resultado = $conexion->query($Existencia);

        if ($resultado->num_rows == 0) {
            // Desactivar anterior Lote
            $Actualizar = "UPDATE lotes SET Activo = '0' WHERE Activo = '1'";
            mysqli_query($conexion, $Actualizar);

            // Insertar nuevo Lote
            $sql = "INSERT INTO lotes (Lote, Activo) VALUES ('$nuevoLote', '1')";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                // Enviar una respuesta para indicar éxito
                echo 'success';
            } else {
                // Enviar una respuesta para indicar un error al agregar el lote
                echo 'error';
            }
        } else {
            // Enviar una respuesta para indicar que el lote ya existe
            echo 'lote_existente';
        }
    }
    
}