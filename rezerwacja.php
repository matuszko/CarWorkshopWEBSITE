<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Strona warsztatu samochodowego">
  <meta name="author" content="Kinga Olszewska, Jakub Matuszko">

  <title>Naprawaam - twój warsztat samochodowy</title>

  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link href="custom_style.css" rel="stylesheet">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>


<body>
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

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="facebook" viewBox="0 0 16 16">
    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
  </symbol>
  <symbol id="instagram" viewBox="0 0 16 16">
    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
  </symbol>
  <symbol id="twitter" viewBox="0 0 16 16">
    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
  </symbol>
  <symbol id="car" viewBox="0 0 21 21">
    <title>Naprawaam</title>
    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 11v-3h1.247c.882 0 1.235.297 1.828.909.452.465 1.925 2.091 1.925 2.091h-5zm-1-3h-2.243c-.688 0-1.051.222-1.377.581-.316.348-.895.948-1.506 1.671 1.719.644 4.055.748 5.126.748v-3zm14 5.161c0-2.823-2.03-3.41-2.794-3.631-1.142-.331-1.654-.475-3.031-.794-.55-.545-2.052-2.036-2.389-2.376l-.089-.091c-.666-.679-1.421-1.269-3.172-1.269h-7.64c-.547 0-.791.456-.254.944-.534.462-1.944 1.706-2.34 2.108-1.384 1.402-2.291 2.48-2.291 4.603 0 2.461 1.361 4.258 3.179 4.332.41 1.169 1.512 2.013 2.821 2.013 1.304 0 2.403-.838 2.816-2h6.367c.413 1.162 1.512 2 2.816 2 1.308 0 2.409-.843 2.82-2.01 1.934-.056 3.181-1.505 3.181-3.829zm-18 4.039c-.662 0-1.2-.538-1.2-1.2s.538-1.2 1.2-1.2 1.2.538 1.2 1.2-.538 1.2-1.2 1.2zm12 0c-.662 0-1.2-.538-1.2-1.2s.538-1.2 1.2-1.2 1.2.538 1.2 1.2-.538 1.2-1.2 1.2zm2.832-2.15c-.399-1.188-1.509-2.05-2.832-2.05-1.327 0-2.44.868-2.836 2.062h-6.328c-.396-1.194-1.509-2.062-2.836-2.062-1.319 0-2.426.857-2.829 2.04-.586-.114-1.171-1.037-1.171-2.385 0-1.335.47-1.938 1.714-3.199.725-.735 1.31-1.209 2.263-2.026.34-.291.774-.432 1.222-.43h5.173c1.22 0 1.577.385 2.116.892.419.393 2.682 2.665 2.682 2.665s2.303.554 3.48.895c.84.243 1.35.479 1.35 1.71 0 1.196-.396 1.826-1.168 1.888z"></path>
  </symbol>
  <symbol id="home" viewBox="0 0 16 16">
    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
  </symbol>
  <symbol id="speedometer2" viewBox="0 0 16 16">
    <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
    <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
  </symbol>
  <symbol id="people-circle" viewBox="0 0 16 16">
    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
  </symbol>
  <symbol id="grid" viewBox="0 0 16 16">
    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
  </symbol>
  <symbol id="telephone" viewBox="0 0 16 16">
    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
  </symbol>
  <symbol id="calendar" viewBox="0 0 16 16">
    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
  </symbol>
</svg>

<!--Nagłówek-->
<header>
  <div class="px-3 py-2 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.html" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none d-none d-lg-block  ">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Naprawaam"><use xlink:href="#car"/></svg>
          <span class="fs-4 ">Naprawa AM</span>
        </a>

        <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
          <li>
            <a href="index.html" class="nav-link text-white">
              <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#home"/></svg>
              Strona główna
            </a>
          </li>
          <li>
            <a href="kontakt.html" class="nav-link text-white">
              <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#telephone"/></svg>
              Kontakt
            </a>
          </li>
          <li>
            <a href="uslugi.html" class="nav-link text-white">
              <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"/></svg>
              Usługi
            </a>
          </li>
          <li>
            <a href="rezerwacja.html" class="nav-link text-secondary">
              <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#calendar"/></svg>
              Rezerwacja
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<!--Kafelki-->
<main>
  <div class="container py-5">
    <main>
      <div class="py-5-sm bg-light rounded-3 text-center">
        <h2>Elektroniczna rezerwacja wizyty</h2>
        <p class="lead px-5-sm">Wypełniając poniższy formularz, możesz zarezerwować wizytę dla swojego samochodu. Po przesłaniu zgłoszenia, nasz pracownik w ciągu 24 godzin, wyśle na podany adres email potwierdzenie terminu (lub zaproponuje inny). </p>
      </div>

      <div class="row py-5 g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary"></span>
            <span class="badge bg-primary rounded-pill">eRezerwacja</span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">Wysłanie zgłoszenia</h6>
                <small class="text-muted">Prześlij zgłoszenie, wraz z wszystkimi najważniejszymi informacjami.</small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">Potwierdzenie, lub zmiana terminu</h6>
                <small class="text-muted">Do 24 godzin, nasz pracownik potwierdzi lub zaproponuje inny termin.</small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">Odpowiedź</h6>
                <small class="text-muted">Na twoją skrzynkę pocztową, lub wiadomość sms, dostaniesz informacje o zarezerwowanym terminie.</small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Wizyta umówiona :)</h6>
                <small>Już tylko oczekujemy, aż przekażesz nam pojazd do naprawy.</small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Odpowiadamy</span>
              <strong>24h/7dni w tygodniu
              </strong>
            </li>
          </ul>

        </div>
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Dane kontaktowe</h4>
          <form class="needs-validation" action="" method="post" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">Imię</label>
                <input type="text" class="form-control" name="imie" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Wprowadź imię
                </div>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Nazwisko</label>
                <input type="text" class="form-control" name="nazwisko" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Wprowadź nazwisko
                </div>
              </div>

              <div class="col-12">
                <label for="username" class="form-label">Numer telefonu <span class="text-muted">(Opcjonalnie)</span></label>
                <div class="input-group has-validation">
                  <span class="input-group-text">#</span>
                  <input type="text" class="form-control" name="numerTelefonu" id="phoneNumber" placeholder="+48 000 000 000">
                  <div class="invalid-feedback">
                    Wprowadź numer telefonu
                  </div>
                </div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <div class="invalid-feedback">
                  Wprowadź poprawny adres email
                </div>
              </div>

              <div class="col-12">
                <label for="ulica" class="form-label">Ulica</label>
                <input type="text" class="form-control" name="ulica" id="ulica" required>
                <div class="invalid-feedback">
                  Wprowadź ulicę
                </div>
              </div>

              <div class="col-12">
                <label for="miejscowosc" class="form-label">Miejscowość</label>
                <input type="text" class="form-control" name="miejscowosc" id="miejscowosc" required>
                <div class="invalid-feedback">
                  Wprowadź miejscowość
                </div>
              </div>

              <div class="col-md-5">
                <label for="kraj" class="form-label">Kraj</label>
                <select class="form-select" name="kraj" id="kraj" required>
                  <option value="">Wybierz...</option>
                  <option>Polska</option>
                  <option>Inny</option>
                </select>
                <div class="invalid-feedback">
                  Wybierz kraj
                </div>
              </div>

              <div class="col-md-3">
                <label for="kod_pocztowy" class="form-label">Kod pocztowy</label>
                <input type="text" class="form-control" name="kodPocztowy" id="kodPocztowy" placeholder="00-000" required>
                <div class="invalid-feedback">
                  Wprowadź kod pocztowy
                </div>
              </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Dane pojazdu</h4>

            <div class="my-3">
              <div class="form-check">
                <input id="osobowy" name="typPojazdu" type="radio" class="form-check-input" checked required>
                <label class="form-check-label" for="osobowy">Samochód osobowy</label>
              </div>
              <div class="form-check">
                <input id="dostawczy" name="typPojazdu" type="radio" class="form-check-input" required>
                <label class="form-check-label" for="dostawczy">Samochód dostawczy</label>
              </div>
              <div class="form-check">
                <input id="inne" name="typPojazdu" type="radio" class="form-check-input" required>
                <label class="form-check-label" for="inne">Inne</label>
              </div>
            </div>

            <div class="row gy-3">
              <div class="col-md-6">
                <label for="numerRejestracyjny" class="form-label">Numer rejestracyjny</label>
                <input type="text" class="form-control" name="numerRejestracyjny" id="numerRejestracyjny" placeholder="" required>
                <small class="text-muted">Pełny numer rejestracyjny pojazdu</small>
                <div class="invalid-feedback">
                  Wprowadź numer rejestracyjny pojazdu
                </div>
              </div>

              <div class="col-md-6">
                <label for="vin" class="form-label">Numer VIN <span class="text-muted">(Opcjonalnie)</span></label>
                <input type="text" class="form-control" name="vin" id="vin" placeholder="">
                <div class="invalid-feedback">
                  Wprowadź numer VIN
                </div>
              </div>

              <div class="col-md-3">
                <label for="marka" class="form-label">Marka</label>
                <input type="text" class="form-control" name="marka" id="marka" placeholder="" required>
                <div class="invalid-feedback">
                  Wprowadź markę pojazdu
                </div>
              </div>

              <div class="col-md-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" name="model" id="model" placeholder="" required>
                <div class="invalid-feedback">
                  Wprowadź model pojazdu
                </div>
              </div>

              <div class="col-md-3">
                <label for="rokProdukcji" class="form-label">Rok produkcji</label>
                <input type="text" class="form-control" name="rokProdukcji" id="rokProdukcji" placeholder="" required>
                <div class="invalid-feedback">
                  Wprowadź rok produkcji pojazdu
                </div>
              </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Zlecenie</h4>

            <div class="gy-3">
              <div class="">
                <label for="opisZlecenia" class="form-label">Opis zlecenia</label>
                <input type="text" class="form-control" name="opisZlecenia" id="opisZlecenia" placeholder="" required>
                <small class="text-muted">Opis czynności, które chcesz, aby zostały wykonane.</small>
                <div class="invalid-feedback">
                  Wprowadź opis zlecenia
                </div>
              </div>

              <div class="">
                <label for="dataZlecenia" class="form-label">Data</label>
                <input type="text" class="form-control" name="dataZlecenia" id="dataZlecenia" placeholder="" required>
                <small class="text-muted">Odpowiednia dla ciebie data, w której możemy wykonać naprawę.</small>
                <div class="invalid-feedback">
                  Wprowadź numer VIN
                </div>
              </div>
            </div>

            <hr class="my-4">

            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="smsInfo" id="smsInfo">
              <label class="form-check-label" for="smsInfo">Proszę o wiadomość SMS, z informacją o dostępnych terminach</label>
            </div>
            <hr class="my-4">

            <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lfg5QokAAAAAGzsTXWpGgPb-lDogGZBY5yuoDJa"></div>
            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" name="submit" type="submit">Zatwierdź</button>
            <?php if(isset($info)) echo $info; ?>
          </form>
        </div>
      </div>
    </main>
  </div>
</main>

<!--Stopka-->
<footer>
  <div class="container d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
        <svg class="bi" width="30" height="24"><use xlink:href="#car"/></svg>
      </a>
      <span class="mb-3 mb-md-0 text-muted">&copy; 2022 Naprawaam.pl</span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
      <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
      <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
    </ul>
  </div>
</footer>

<script src="/js/form-validation.js"></script>
</body>
</html>
