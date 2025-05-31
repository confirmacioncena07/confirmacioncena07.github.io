<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

// Validar entrada
$nombre = htmlspecialchars($_POST['nombre'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');

if (!$nombre || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Datos inválidos. <a href='index.html'>Volver</a>";
    exit;
}

// Guardar en archivo
$linea = "Nombre: $nombre - Email: $email" . PHP_EOL;
file_put_contents("confirmaciones.txt", $linea, FILE_APPEND);

// Enviar correo
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'confirmacionescena@gmail.com';
    $mail->Password = 'gypy asep yjcr oudf'; // <--- Sustituye esto por tu contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('confirmacionescena@gmail.com', 'Invitación Fiesta');
    $mail->addAddress($email, $nombre);

    $mail->isHTML(true);
    $mail->Subject = 'Gracias por confirmar tu asistencia 🙌🏽';
    $mail->Body = "Hola <b>$nombre</b>,<br><br>¡Gracias por confirmar tu asistencia a la fiesta!<br>Nos vemos pronto 🎈🥤";

    $mail->send();
    echo "¡Gracias por confirmar, $nombre!<br><a href='index.html'>Volver</a>";
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}<br><a href='index.html'>Volver</a>";
}
?>
