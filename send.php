<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {
  
    $mail = new PHPMailer(true);

    $mail -> isSMTP();  
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username = 'fancyexpenses@gmail.com';
    $mail -> Password = 'pihhivqrqfrubess';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;

    $mail -> setFrom('fancyexpenses@gmail.com');

    $mail -> addAddress($_POST['email']);

    $mail -> isHTML(true);

    $mail->Subject = "New Account Created";
    $mail->Body = "Dear Mr/Mrs ".$username.",<br><br>Thank you for creating an account in Fancy Expenses<br>";
    $mail->send();
    echo '<script>alert("Account created successfully!\nPlease check your email!\nClick Okay will automatically redirect to login page.")</script>';
    header("Refresh:1; Url=login.php");
    
    exit();
} else{

}



?>