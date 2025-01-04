<?php
include "./header.php";

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);

$shooterID=intval($_GET[id]);
$klic=intval($_GET[klic]);
$dnes=date_format(new DateTime(),"d.m.Y H:i");

$query="select * from $table WHERE Cislo=$shooterID and klic=$klic";
$result=mysql_query($query);

// nelze dohledat zavodnika
if (!$strelec=mysql_fetch_array($result)) {
echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-secondary text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='white-text'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger'>
				Nelze dohledat závodníka v databázi
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-primary' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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
// zavodnik uz zaplatil
$query="select * from $table WHERE Cislo=$shooterID and klic=$klic";
$result=mysql_query($query);
$z=mysql_fetch_array($result);

if (($z[Zaplaceno]=="on") and (($z[VIP]!=="on") xor ($z[RO]!=="on") xor ($z[POM]!=="on")) ) {
	echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-secondary text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='white-text'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger pb-3'>
				Startovné s variabilním symbolem $z[VarSym] (závodník $z[Jmeno] $z[Prijmeni] \"$z[Alias]\") je uhrazené. Účast v závodu již nelze zrušit
			</div>
			<div class='col-12'>
				<i class='far fa-info-circle pr-2' style='font-size:16px'></i>V souladu s pravidly závodu je možné startovné přenést na jiného závodníka.
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-primary' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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
// konecne vyrazujeme zavodnika
$ip=$_SERVER["REMOTE_ADDR"];
$query="UPDATE ".$table." SET Squad=-9, Vyrazeno='$dnes', VyrazenoIP='$ip' WHERE Cislo=$shooterID and klic=$klic";
$result = mysql_query($query);

  if (!$result) {
      echo"<FONT COLOR=RED> Omlouvame se - došlo k chybě pri vkládaní do databáze - zkuste to později</FONT><BR>";
      echo "<pre>".'MySQL Error: ' . mysql_error() ."</pre>";
  } elseif (mysql_affected_rows()==0) {
      echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-secondary text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='white-text'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
			<div class='col-12 font-weight-bolder text-danger pb-3'>
				Změna je již v databázi zaevidovaná
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-primary' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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
  } else
{
  $query="select * from $table where Cislo=$shooterID";
  $strelci=mysql_query($query);
  $z=mysql_fetch_array($strelci);

  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
  $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="ZRUŠENO Z IP: $ip"."\r\n";

  $subject = "Zrušení registrace závodníka - ".$match_data[Zavod];
  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$z[Mail];
  $message=$email_text_vyrazeni_vlastni;
  $message=str_replace("##STRELEC##", $STRELEC, $message);

if (email($from_text,$from,$to, $subject, $message)) {
      echo "
 <div class='text-center'>
	<img src='./images/EC_ASCII.png'>
 </div>
 <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-secondary text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Vyřazení závodníka</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='window.location.href = 'index.php';'>
			<span aria-hidden='true' class='white-text'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center '>
			<div class='col-12 font-weight-bolder pb-2'>
				Byl(a) jste vyřazen(a) ze závodu <strong>$match_data[Zavod]</strong>.
			</div>
			<div class='col-12 pb-3'>
				Děkujeme za uvolnění místa případnému dalšímu zájemci.
			</div>
			<div class='col-12'>
				<i class='far fa-info-circle pr-1' style='font-size:13px'></i>Email s informací byl zaslán na adresu zadanou při registraci
			</div>
		</div>
		<div class='modal-footer border-top-0 col-12'>
			<button type='button' class='btn btn-primary' onclick=\"window.location.href = 'index.php';\">Zavřít</button>
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

// pošle informaci o zrušení registrace na registrace@kps-eggenberg.cz (antoni.liska@seznam.cz)
	$subject = "Zrušení registrace závodníka - ".$match_data[Zavod];
	$from_text="";
	$from=$match_data[Zavod_email_from];
	$to=$match_data[Zavod_email_from];
	$message = "Závodník zrušil svoji účast.

##STRELEC##
";
// to-do neodeslani  emailu

$message=str_replace("##STRELEC##",$STRELEC,$message);
email($from_text,$from,$to, $subject, $message);
};

?>
</body>
</html>