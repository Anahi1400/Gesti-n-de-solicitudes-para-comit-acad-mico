<?php
include('Bd.php');
error_reporting(0);

    // generar_excel.php
    require 'C:\xampp\htdocs\Residencia\vendor\autoload.php'; 
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    // Crear un nuevo objeto PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    
    // Obtener la hoja activa
    $sheet = $spreadsheet->getActiveSheet();
    
    // Establecer los encabezados de la tabla en el archivo Excel
    $sheet->setCellValue('A1', 'No. Control')
        ->setCellValue('B1', 'Nombre')
        ->setCellValue('C1', 'Carrera')
        ->setCellValue('D1', 'Estatus')
        ->setCellValue('E1', 'Comentarios');

    // Obtener datos de la base de datos
    $consulta = mysqli_query($conexion, "SELECT s.*, l.Id_Lote FROM solicitudes s JOIN lotes l ON s.Lote = l.Id_Lote WHERE l.Activo = 1");

    $row = 2; // Comenzar desde la segunda fila
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $Id = $fila['Id_Solicitud'];
        $sql = mysqli_query($conexion, "SELECT Id_Estudiante FROM estudiante_solicitud WHERE Id_Solicitud = $Id");
        $fila1 = mysqli_fetch_assoc($sql);

        if (isset($fila1['Id_Estudiante'])) {
            $Id_Estudiante = $fila1['Id_Estudiante'];
            $sql2 = mysqli_query($conexion, "SELECT * FROM estudiante WHERE Id_Estudiante = '$Id_Estudiante'");
            $fila2 = mysqli_fetch_assoc($sql2);

            $Id_Carrera = $fila2['Id_Carrera1'];
            $sql3 = mysqli_query($conexion, "SELECT NombreCarrera FROM carrera WHERE Id_Carrera = '$Id_Carrera'");
            $fila3 = mysqli_fetch_assoc($sql3);
        }

        // Agregar datos a las celdas correspondientes en el archivo Excel
        $sheet->setCellValue('A' . $row, $fila2['No_Control'])
              ->setCellValue('B' . $row, $fila2['Nombre'])
              ->setCellValue('C' . $row, $fila3['NombreCarrera'])
              ->setCellValue('D' . $row, $fila['Estatus'])
              ->setCellValue('E' . $row, $fila['Comentarios']);

        $row++; // Moverse a la siguiente fila
    }

    $filename = 'Solicitudes' . date('YmdHis') . '.xlsx';

    // Configurar la descarga del archivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    unset($spreadsheet);
?>