<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
  list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

$valid_passwords = array ("user1" => "password1");

$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="Eggenberg 30082019"');
  header('HTTP/1.0 401 Unauthorized');
  die ("<center><h1>Chyba autentizace</h1><img src='../images/denied.jpeg'></center>");
}
?>
