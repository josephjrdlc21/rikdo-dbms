<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'autoload.php';

    $mail = new PHPMailer(true);

    try {                      
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'columbanrikdo@gmail.com';                     
        $mail->Password   = 'meudbhclvrhcsxwt';                               
        $mail->SMTPSecure = 'ssl';            
        $mail->Port       = 465;                                    
    
        $mail->setFrom('columbanrikdo@gmail.com');
        $mail->addAddress('gsrchsll@gmail.com');    
    
        $mail->isHTML(true);                                 
        $mail->Subject = 'JAKE THE GREAT';
        $mail->Body    = 'The reject shit of the year! <b>JABOLS</b>';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>