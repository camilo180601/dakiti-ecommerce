<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;      
    $mail->isSMTP();                     
    $mail->Host       = 'smtp-mail.outlook.com';    
    $mail->SMTPAuth   = true;                         
    $mail->Username   = 'camilo06180401@outlook.com';    
    $mail->Password   = 'c123451000472912';        
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
    $mail->Port       = 587;                           

    //Recipients
    $mail->setFrom('camilo06180401@outlook.com', 'Tienda Camele');
    $mail->addAddress($email, 'Usuario/a Tienda Camele');
    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Detalles de su Compra';
    
    $cuerpo = '<h4 style="text-align:center; font-style: italic; font-size: 20px;">Gracias por su compra</h4><br>
                <div style="text-align:center;" >
                    <a href="https://https://camele.epizy.com">
                        <img src="https://i.imgur.com/Issna1P.jpg" title="source: imgur.com" height="250px" width="250px" style="text-align:center; border: 5px outset silver;" />
                    </a><br>
                </div>';    

    $cuerpo .= '<p style="text-align:center;">
                   El ID de su compra es: <b>'. $id_transaccion .'</b><br>
                   La fecha de su compra es: <b>'. $fecha .'</b><br>
                   Su pedido sera enviado a la direccion <b>'. $dir_compra.'</b> de la ciudad de <b>'.$ciudad_cliente. '</b><br>
                   El total de su compra es: <b>'. MONEDA . number_format($total, 2, '.', ',') ;'</b><br>
                </p>';

    $mail->Body = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');
    $mail->send();

} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
}