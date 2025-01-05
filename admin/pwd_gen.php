<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}


//$salt = "1234";
//$password = $_POST['password'];
//$md5 = md5($salt.$password);
//echo "$md5";

//echo password_hash("pwd", PASSWORD_DEFAULT);
?>