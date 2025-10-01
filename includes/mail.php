<?php
// Funciones para envío de correos
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoContacto($datos)
{
    require_once __DIR__ . '/../config/data_loader.php';
    $empresa = empresa();

    $nombre = htmlspecialchars($datos['nombre']);
    $email = htmlspecialchars($datos['email']);
    $telefono = htmlspecialchars($datos['telefono']);
    $servicio = htmlspecialchars($datos['servicio']);
    $mensaje = htmlspecialchars($datos['mensaje']);

    // Guardar contacto en contactos.json
    $contacto = [
        'nombre' => $nombre,
        'email' => $email,
        'telefono' => $telefono,
        'servicio' => $servicio,
        'mensaje' => $mensaje,
        'fecha' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ];
    $contactos_file = __DIR__ . '/../data/contactos.json';
    $contactos = [];
    if (file_exists($contactos_file)) {
        $json = file_get_contents($contactos_file);
        $contactos = json_decode($json, true);
        if (!is_array($contactos)) $contactos = [];
    }
    $contactos[] = $contacto;
    file_put_contents($contactos_file, json_encode($contactos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Envío con PHPMailer
    // (ya está incluido y los use statements están al inicio del archivo)

    $mail = new PHPMailer(true);
    // $mail = new PHPMailer(true);
    try {
        // Configuración SMTP (EDITA ESTOS DATOS)
        $mail->isSMTP();
        $mail->Host = 'mail.creditoexpres.com'; // Cambia por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'estadodecredito@creditoexpres.com'; // Cambia por tu usuario
        $mail->Password = 'S@lvacero2024*'; // Cambia por tu contraseña
        $mail->SMTPSecure = 'ssl'; // tls o ssl
        $mail->Port = 465; // 587 para TLS, 465 para SSL

        // $mail->setFrom($email, $nombre);
        $mail->addAddress("jalvaradoe3@gmail.com");
        // $mail->addReplyTo($email, $nombre);
        $mail->Subject = "Nuevo contacto desde la web - " . $empresa['nombre'];
        $mail->isHTML(true);
        $mail->Body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #B91C1C; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #333; }
            .value { margin-top: 5px; padding: 10px; background-color: white; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nuevo Mensaje de Contacto</h2>
                <p>{$empresa['nombre']}</p>
            </div>
            <div class='content'>
                <div class='field'><div class='label'>Nombre:</div><div class='value'>$nombre</div></div>
                <div class='field'><div class='label'>Email:</div><div class='value'>$email</div></div>
                <div class='field'><div class='label'>Teléfono:</div><div class='value'>$telefono</div></div>
                <div class='field'><div class='label'>Servicio de Interés:</div><div class='value'>$servicio</div></div>
                <div class='field'><div class='label'>Mensaje:</div><div class='value'>$mensaje</div></div>
                <div class='field'><div class='label'>Fecha y Hora:</div><div class='value'>" . date('d/m/Y H:i:s') . "</div></div>
            </div>
        </div>
    </body>
    </html>
    ";
        $mail->AltBody = "Nuevo mensaje de contacto de $nombre ($email)\nTeléfono: $telefono\nServicio: $servicio\nMensaje: $mensaje";
        $mail->send();
        return [true, null];
    } catch (Exception $e) {
        return [false, $mail->ErrorInfo ?: $e->getMessage()];
    }
}

function enviarCorreoConfirmacion($email, $nombre)
{
    require_once __DIR__ . '/../config/data_loader.php';
    $empresa = empresa();

    $asunto = "Gracias por contactarnos - " . $empresa['nombre'];
    $cuerpo = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #B91C1C; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; line-height: 1.6; }
            .footer { background-color: #f9f9f9; padding: 15px; text-align: center; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>{$empresa['nombre']}</h2>
                <p>{$empresa['slogan']}</p>
            </div>
            <div class='content'>
                <h3>¡Hola $nombre!</h3>
                <p>Gracias por contactarnos. Hemos recibido tu mensaje y uno de nuestros especialistas se pondrá en contacto contigo en las próximas horas.</p>
                <p><strong>¿Necesitas atención inmediata?</strong></p>
                <p>Llámanos al: <strong>{$empresa['telefono_display']}</strong></p>
                <p>O escríbenos por WhatsApp: <strong>{$empresa['telefono_display']}</strong></p>
                <p><strong>Nuestros horarios de atención:</strong></p>
                <ul>
                    <li>Lunes a Viernes: {$empresa['horarios']['lunes_viernes']}</li>
                    <li>Sábados: {$empresa['horarios']['sabados']}</li>
                    <li>Domingos: {$empresa['horarios']['domingos']}</li>
                </ul>
            </div>
            <div class='footer'>
                <p><strong>{$empresa['nombre']}</strong></p>
                <p>Control de Plagas Profesional | {$empresa['telefono_display']}</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail = new PHPMailer(true);
    try {
        // Configuración SMTP (igual que arriba, edita los datos)
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email'; // Cambia por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'contactos@fastcontrolpest.com'; // Cambia por tu usuario
        $mail->Password = 'contactos*1'; // Cambia por tu contraseña
        $mail->SMTPSecure = 'tls'; // tls o ssl
        $mail->Port = 587; // 587 para TLS, 465 para SSL

        $mail->setFrom($empresa['email_contacto'], $empresa['nombre']);
        $mail->addAddress($email, $nombre);
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body = $cuerpo;
        $mail->AltBody = "Hola $nombre, gracias por contactarnos. Pronto te responderemos.";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function Prueba_Correo()
{

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'facturacion@fastcontrolpest.com';
        $mail->Password = 'facturacion*1';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom('contactos@fastcontrolpest.com', 'Tu Nombre');
        $mail->addAddress('jalvaradoe3@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Asunto del correo';
        $mail->Body    = 'Este es el contenido del correo en HTML';

        if (!$mail->send()) {
            // Mostrar error SMTP y detalles
            $errorMsg = "Mail error: " . $mail->ErrorInfo;
            if (isset($mail->smtp) && method_exists($mail->smtp, 'getLastReply')) {
                $smtpReply = $mail->smtp->getLastReply();
                if ($smtpReply) {
                    $errorMsg .= "<br>SMTP reply: " . htmlspecialchars($smtpReply);
                }
            }
            return [false, $errorMsg];
        } else {
            return [true, "Correo enviado correctamente."];
        }
    } catch (Exception $u) {
        $errorMsg = "Excepción: " . $u->getMessage();
        if (isset($mail) && $mail->ErrorInfo) {
            $errorMsg .= "<br>PHPMailer ErrorInfo: " . $mail->ErrorInfo;
        }
        return [false, $errorMsg];
    }
}
