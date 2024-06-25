<?php

if (!function_exists('loadEnv')) {
    function loadEnv($path)
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $vars = [];
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $vars[$name] = $value;
            }
        }

        return $vars;
    }
}

$env = loadEnv(__DIR__ . '/.env');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($env, $email, $message)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $env['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $env['SMTP_USERNAME'];
        $mail->Password   = $env['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom($env['SMTP_USERNAME'], $env['NAME']);
        $mail->addAddress($email);
        $mail->addReplyTo($env['EMAIL'], $env['NAME']);

        $mail->isHTML(true);
        $mail->Subject = $env['SUBJECT'];
        $mail->Body    = $message;

        $mail->send();

        echo "<script>alert('Password reset token sent to your email!'); window.location.href = 'login.php';</script>";
    } catch (Exception $e) {
        echo "
        <script> 
         alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        </script>
        ";
    }
}

if (isset($_POST["send"])) {
    sendEmail($env, $_POST["email"], $message);
}
