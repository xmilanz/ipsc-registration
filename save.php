<?php 
	include "./header.php";

// VYRAZENI ZAVODNIKA
if (isset($_GET[cancel_shooter])) {
$ip=($_SERVER["REMOTE_ADDR"]);

$query="select * from $table WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result=mysql_query($query);

if (!$result) {
  die('<strong><FONT COLOR=RED>Nelze dohledat závodníka</FONT></strong>');
}

$line=mysql_fetch_array($result);

$query="UPDATE ".$table." SET SquadReg='$line[Squad]',Squad='-9',Vyrazeno='$dnes',VyrazenoIP='$ip' WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result = mysql_query($query);

if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}

else {
$query="select * from $table WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result = mysql_query($query);
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
		<div class='modal-body text-center '>
			<div class='col-12 font-weight-bolder text-danger pb-2'>
				Závodník $line[Jmeno] $line[Prijmeni] '$line[Alias]' byl vyřazen ze závodu <strong>$match_data[Zavod]</strong>.
			</div>
			<div class='col-12 pb-3'>
				Děkujeme za uvolnění místa případnému dalšímu zájemci.
			</div>
			<div class='col-12'>
				<i class='far fa-info-circle pr-1' style='font-size:13px'></i>Email s informací byl odeslán na adresu $line[Mail] zadanou při registraci.
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-default' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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

// posilame mail zavodnikovi
$query="select * from $table where Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$strelci=mysql_query($query);
$z=mysql_fetch_array($strelci);

   $STRELEC="ALIAS: $z[Alias]"."\r\n";
   $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
   $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";

   $from_text="";
   $from=$match_data[Zavod_email_from];
   $to=$z[Mail];
   $subject = "Zrušení registrace závodníka ".$match_data[Zavod];
   $message=$email_text_vyrazeni_vlastni;
   $message=str_replace("##STRELEC##", $STRELEC, $message);

$send_email = email($from_text,$from,$to,$subject, $message);

}
// KONEC VYRAZENI ZAVODNIKA

?>
