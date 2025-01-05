<?php
include "header.php";
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
?>