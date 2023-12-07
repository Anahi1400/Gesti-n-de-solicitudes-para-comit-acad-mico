<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include('Agregar_Usuario.php');
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$enviado = false;
try {
    //Server settings
                         //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'solicitudestecmmzapopan@gmail.com';                     //SMTP username
    $mail->Password   = 'imfl vush vhik srjk';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );

    //Archivo de códigos de verificación
    $archivoRegistro = 'codigos_generados.txt';

    // Leer códigos generados previamente desde el archivo
    $contenidoArchivo = file_get_contents($archivoRegistro);
    $codigosGenerados = $contenidoArchivo ? unserialize($contenidoArchivo) : array();

    // Generar un código único
    do {
        $codigo = rand(1000, 9999);
    } while (in_array($codigo, $codigosGenerados));

    // Guardar el código generado en el registro
    $codigosGenerados[] = $codigo;
    file_put_contents($archivoRegistro, serialize($codigosGenerados));

    //Recipients
    $mail->setFrom('solicitudestecmmzapopan@gmail.com', 'verificacion');
    $mail->addAddress($Correo);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verificar tu correo';
    $mail->Body    = '
        <p>Tu código de verificación es: <strong>'.$codigo.'</strong></p>
        <p>Para verificar tu correo, haz clic en el siguiente enlace:</p>
        <p><a href="http://localhost:3000/Confirmar.php?correo='.$Correo.'">Verificar correo</a></p>
    ';

    $mail->send();
    $enviado = true;
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

?>