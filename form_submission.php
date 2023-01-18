$recaptcha = $_POST['g-recaptcha-response'];
$res = reCaptcha($recaptcha);
if(!$res['success']){
// Error
}
<?php
if (isset($_POST['submit'])) {
$secret = '6Lfg5QokAAAAAMsEOJQDDpaU35XPBFQwekGyiFA9';
$response = $_POST['g-recaptcha-response'];
$remoteip = $_SERVER['REMOTE_ADDR'];

$url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
$result = json_decode($url, TRUE);
if ($result['success'] == 1) {
echo 'Weryfikacja reCaptcha - poprawna';
}else{
echo 'Błędnie wypełnione pole reCAPTCHA';
}
}