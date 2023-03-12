<?php
require_once "PHPMailer/PHPMailer/PHPMailer.php";
require_once "PHPMailer/PHPMailer/Exception.php";
require_once "connection.php";
new database();
//mail
const MAIL_HOST = '---';
const SMTP_AUTH = true;
const MAIL_USERNAME = '---';
const MAIL_PASSWORD = '';
const MAIL_PORT = 587;
const SENDER_MAIL = '----';
const SENDER_NAME = '------';

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["email"])) {
    var_dump($_GET["email"]);
    $rand = rand(10000, 99999);
    echo "\n".$rand."\n";
    database::select("SELECT * FROM `users`");
}
function sendMail($emailAddress, $subject, $body)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->CharSet = "UTF-8"; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = MAIL_HOST; //Set the SMTP server to send through
        $mail->SMTPAuth = SMTP_AUTH; //Enable SMTP authentication
        $mail->Username = MAIL_USERNAME; //SMTP username
        $mail->Password = MAIL_PASSWORD; //SMTP password
        $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
        $mail->Port = MAIL_PORT; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(SENDER_MAIL, SENDER_NAME);
        $mail->addAddress($emailAddress);


        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="get">
    <input type="text" name="email" id="">
    <input type="submit" value="">
</form>
</body>
</html>