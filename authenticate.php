<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs"">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo "$match_data[Zavod]"; ?></title>
    <link rel="shortcut icon" href="./images/favicon.ico" />
	<link rel="apple-touch-icon" href="./images/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="./images/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="./images/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="./images/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="./images/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="./images/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="./images/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="./images/apple-touch-icon-152x152.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon-180x180.png" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed%3A400%2C700%7CArimo%3A400%2C700&#038;ver=eb423f0ac3bea64e1037184f3b727fe6" type="text/css" media="all" />
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- bootstrap -->
	<link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<div class="container">

<div class="header">
	<div class="header-logo">
		<img src="./images/logo-blank-dvc.png" alt="Logo">
		<div class="text-over-image">
			<a class="logo-text" href="<?php echo "$match_data[Klub_web]"; ?>" target="_blank">
				<p class="mt-2"><?php echo "$match_data[Zavod_poradatel]<br>";?></a></p>
		</div>
	</div>
</div>

<nav class="navbar navbar-expand-md sticky-top navbar-dark">
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav font-weight-bold">
    <li class="nav-item">
      <a class="nav-link" href="./">Propozice</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./registrace.php">Registrace</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./zavodnici.php">Závodníci</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./situace.php">Situace</a>
    </li>
    <li class="nav-item">
      <a class='nav-link' href='./kontrola_aliasu.php'>Aliasy</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $match_data[Zavod_vysledky];?>">Výsledky</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./login.php">&nbsp<i class='fas fa-user-lock' style='font-size:16px'></i>&nbsp;</a>
    </li>
  </ul>
  </div>
</nav>

<div id="main">
	<div id="content">

<?php
require_once ("./config/data.php");
session_start();

$con = mysqli_connect($db_host, $db_login, $db_pass, $db_dtb);
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Zadejte jméno a heslo');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password FROM site_admins WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($_POST['password'], $password)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
		header('Location: ./admin/index.php');
	} else {
		// Incorrect password

echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Přihlášení do administrace závodu</h4> <br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick=\"window.location.href = 'login.php';\">
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger'>
				Chyba autentizace.<br>Zadejte správné heslo a zkuste to znovu.
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'login.php';\">Zpět na přihlášení</button>
		</div>
		</div>
 </div>
 </div>

<script  type='text/javascript'>
var myModal = new bootstrap.Modal(document.getElementById('regInfo'));
	myModal.show();
    backdrop: 'static',
    keyboard: false
</script>

<script  type='text/javascript'>
	$('#regInfo').modal({
		backdrop: 'static',
		keyboard: false
	})
</script>
		";

	}
} else {
	// Incorrect username
echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Přihlášení do administrace závodu</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick=\"window.location.href = 'login.php';\">
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger'>
				Chyba autentizace - uživatel '$_POST[username]' neexistuje.<br>Zadejte správné uživatelské jméno a zkuste to znovu.
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'login.php';\">Zpět na přihlášení</button>
		</div>
		</div>
 </div>
 </div>

<script  type='text/javascript'>
var myModal = new bootstrap.Modal(document.getElementById('regInfo'));
	myModal.show();
    backdrop: 'static',
    keyboard: false
</script>

<script  type='text/javascript'>
	$('#regInfo').modal({
		backdrop: 'static',
		keyboard: false
	})
</script>
		";
}

    $stmt->close();
}

include "footer.php";
