<?php
// Funciones para envío de correos
function enviarCorreoContacto($datos) {
    $empresa = include '../config/empresa.php';
    
    $nombre = htmlspecialchars($datos['nombre']);
    $email = htmlspecialchars($datos['email']);
    $telefono = htmlspecialchars($datos['telefono']);
    $servicio = htmlspecialchars($datos['servicio']);
    $mensaje = htmlspecialchars($datos['mensaje']);
    
    $destinatario = $empresa['email_contacto'];
    $asunto = "Nuevo contacto desde la web - " . $empresa['nombre'];
    
    $cuerpo = "
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
                <div class='field'>
                    <div class='label'>Nombre:</div>
                    <div class='value'>$nombre</div>
                </div>
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div class='value'>$email</div>
                </div>
                <div class='field'>
                    <div class='label'>Teléfono:</div>
                    <div class='value'>$telefono</div>
                </div>
                <div class='field'>
                    <div class='label'>Servicio de Interés:</div>
                    <div class='value'>$servicio</div>
                </div>
                <div class='field'>
                    <div class='label'>Mensaje:</div>
                    <div class='value'>$mensaje</div>
                </div>
                <div class='field'>
                    <div class='label'>Fecha y Hora:</div>
                    <div class='value'>" . date('d/m/Y H:i:s') . "</div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    
    return mail($destinatario, $asunto, $cuerpo, $headers);
}

function enviarCorreoConfirmacion($email, $nombre) {
    $empresa = include '../config/empresa.php';
    
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
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $empresa['email'] . "\r\n";
    
    return mail($email, $asunto, $cuerpo, $headers);
}
?>
