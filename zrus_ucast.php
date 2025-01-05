<?
require_once ("./config/data.php");
require ("./header.php");

$shooterID=intval($_GET[id]);
$shooterKEY=intval($_GET[klic]);

$query="select * from $table WHERE Cislo=$shooterID and klic=$shooterKEY";
$result=mysql_query($query);


// nelze dohledat zavodnika
if (!$result) {
echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger'>
				Nelze dohledat závodníka v databázi
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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
	exit;
}


// ZÁVODNÍK UŽ JE VYŘAZENÝ (squad -9)
$result=mysql_query($query);
$line=mysql_fetch_array($result);

if ($line[Squad]=='-9') {
echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger'>
				Závodník $line[Jmeno] $line[Prijmeni] '$line[Alias]' je již vyřazený.<br>
			</div>
		</div>
			<div class='col-12 text-center'>
				<i class='far fa-info-circle pr-2' style='font-size:16px'></i> Pokud jste tuto akci neprovedli, neprodleně nás kontaktujte.
			</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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
	exit;
} 

// KONEČNĚ VYŘAZUJEME
else {

$result=mysql_query($query);
$line=mysql_fetch_array($result);

echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>

		<form class='row needs-validation mb-0' method='post' action='./save.php?cancel_shooter' >
	  <!-- ID závodnika a klic -->
		<INPUT type='hidden' id='shooterID' name='shooterID' value='$shooterID'>
		<INPUT type='hidden' id='shooterKEY' name='shooterKEY' value='$shooterKEY'>
	  <!-- ID zavodnika a klic -->
	  <div class='col-12 mb-3 font-weight-bolder text-danger'>
		Závodník $line[Jmeno] $line[Prijmeni] '$line[Alias]' bude vyřazen.
	  </div>
			<div class='col-12 text-center'>
				<i class='far fa-info-circle pr-2' style='font-size:16px'></i>Pokud jste provedli platbu registračního poplatku, můžete místo vyřazení přenést startovné na jiného závodníka.
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='submit' class='btn btn-danger'>Vyřadit závodníka</button>
			<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zrušit</button>
		</div>
		</form>
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

?>
