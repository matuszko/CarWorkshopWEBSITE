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
    if ($result['success'] == 1) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '20c4d79f88ea80';
            $mail->Password = 'c296da0d48b5b4';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('info@mailtrap.io', 'Mailer');
            $mail->addAddress('kubamatuszko@gmail.com');


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Rezerwacja NAPRAWAAM.PL';
            $mail->Body = "
            <html>
            <head>
              <title>Rezerwacja wizyty</title>
            </head>
            <body>
            <p>Dane te zostałī wypełnione poprzez formularz na stronie www.naprawaam.pl</p>
            <table>
              <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Numer telefonu</th>
                <th>Email</th>
                <th>Ulica</th>
                <th>Miejscowość</th>
                <th>Kraj</th>
                <th>Kod pocztowy</th>
              </tr>
              <tr>
                <th>Typ pojazdu</th>
                <th>Numer rejestracyjny</th>
                <th>Numer VIN</th>
                <th>Marka</th>
                <th>Model</th>
                <th>Rok produkcji</th>
              </tr>
              <tr>
                <td>". $_POST['imie'] ."</td>
                <td>". $_POST['nazwisko'] ."</td>
                <td>". $_POST['numerTelefonu'] ."</td>
                <td>". $_POST['email'] ."</td>
                <td>". $_POST['ulica'] ."</td>
                <td>". $_POST['miejscowosc'] ."</td>
                <td>". $_POST['kraj'] ."</td>
                <td>". $_POST['kodPocztowy'] ."</td>
              </tr>
              <tr>
                <td>". $_POST['typPojazdu'] ."</td>
                <td>". $_POST['numerRejestracyjny'] ."</td>
                <td>". $_POST['vin'] ."</td>
                <td>". $_POST['marka'] ."</td>
                <td>". $_POST['model'] ."</td>
                <td>". $_POST['rokProdukcji'] ."</td>
              </tr>
            </table>
            <br>
            <h1>Zlecenie:</h1>
            <br>
            <table>
              <tr>
                <th>Opis zlecenia</th>
                <th>Data</th>
                <th>SMS</th>
              </tr>
              <tr>
                <td>". $_POST['opisZlecenia'] ."</td>
                <td>". $_POST['dataZlecenia'] ."</td>
                <td>". $_POST['smsInfo'] ."</td>
              </tr>
            </table>
            </body>
            </html>
            ";
            $message =
                $mail->send();
            $info =  'Rezerwacja została wysłana';
        } catch (Exception $e) {
            $info =  "Rezerwacja nie może zostać wysłana (skontaktuj się z nami telefonicznie). Kod błędu: {$mail->ErrorInfo}";
        }
    } else {
        $info = 'Błędnie wypełnione pole reCAPTCHA';
    }
}
?>