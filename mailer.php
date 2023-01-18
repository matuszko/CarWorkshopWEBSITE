<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


if (isset($_POST['submit'])) {
    $secret = '6Lfg5QokAAAAAMsEOJQDDpaU35XPBFQwekGyiFA9';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
    $result = json_decode($url, TRUE);
    if ($result['success'] != 1) {
        echo 'Weryfikacja reCaptcha - poprawna';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = '20c4d79f88ea80';                     //SMTP username
            $mail->Password = 'c296da0d48b5b4';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('info@mailtrap.io', 'Mailer');
            $mail->addAddress('kubamatuszko@gmail.com');     //Add a recipient
            $mail->addReplyTo('info@mailtrap.io', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Rezerwacja NAPRAWAAM.PL';
            $mail->Body = "
            <html>
                <head>
                    <title>HTML email</title>
                </head>
                <body>
                    <p>This email contains HTML Tags!</p>
                    <table>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                        </tr>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                        </tr>
                    </table>
                </body>
            </html>
            ";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $message =
                $mail->send();
            echo 'Wiadomość została wysłana';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Błędnie wypełnione pole reCAPTCHA';
    }
}


