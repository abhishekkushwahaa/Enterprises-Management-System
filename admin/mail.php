<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($email, $name, $password) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;                                 
        $mail->isSMTP();                                      
        $mail->Host = 'smtp1.example.com';  
        $mail->SMTPAuth = true;                               
        $mail->Username = 'user@example.com';                 
        $mail->Password = 'secret';                           
        $mail->SMTPSecure = 'tls';                            
        $mail->Port = 587;                                    

        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($email, $name);     


        $mail->isHTML(true);                                  
        $mail->Subject = 'Welcome to IITS Path';
        $mail->Body    = "Dear $name, you have been added to IITS Path as an employee. Your login credentials are as follows: <br>Email: $email <br>Password: $password";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>