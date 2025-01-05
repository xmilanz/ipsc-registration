    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php 
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

include ("../db/dbconn.php");

// KONFIGRACE ZAVODU
if (isset($_GET[match_config])) {

 if ($match_data[Payment_before]=="on"){
	$query="UPDATE match_config SET
		Banka_ucet_CASTKA='$_POST[Banka_ucet_CASTKA]',
		Banka_ucet_cislo='$_POST[Banka_ucet_cislo]',
		Banka_ucet_kod='$_POST[Banka_ucet_kod]',
		Banka_nazev='$_POST[Banka_nazev]',
		Banka_adresa='$_POST[Banka_adresa]',
		Klub_web='$_POST[Klub_web]',
		Zavod='$_POST[Zavod]',
		Zavod_datum='$_POST[Zavod_datum]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_main_dopoledne='$_POST[Zavod_cas_main_dopoledne]',
		Zavod_cas_main_odpoledne='$_POST[Zavod_cas_main_odpoledne]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_poradatel='$_POST[Zavod_poradatel]',
		Zavod_poradatel_adresa='$_POST[Zavod_poradatel_adresa]',
		Zavod_match_director='$_POST[Zavod_match_director]',
		Zavod_email_poradatel='$_POST[Zavod_email_poradatel]',
		Zavod_telefon_poradatel='$_POST[Zavod_telefon_poradatel]',
		Zavod_range_master='$_POST[Zavod_range_master]',
		Zavod_email_range_master='$_POST[Zavod_email_range_master]',
		Zavod_telefon_range_master='$_POST[Zavod_telefon_range_master]',
		Zavod_stats='$_POST[Zavod_stats]',
		Zavod_email_stats='$_POST[Zavod_email_stats]',
		Zavod_telefon_stats='$_POST[Zavod_telefon_stats]',
		Zavod_hospodar='$_POST[Zavod_hospodar]',
		Zavod_email_hospodar='$_POST[Zavod_email_hospodar]',
		Zavod_telefon_hospodar='$_POST[Zavod_telefon_hospodar]',
		Zavod_email_from='$_POST[Zavod_email_from]',
		Zavod_stages='$_POST[Zavod_stages]',
		Zavod_min_pocet_ran='$_POST[Zavod_min_pocet_ran]',
		Zavod_pocet_dni_na_platbu='$_POST[Zavod_pocet_dni_na_platbu]',
		Zavod_vysledky='$_POST[Zavod_vysledky]',
		Squad_main_max='$_POST[Squad_main_max]',
		Squad_prem_max='$_POST[Squad_prem_max]'
	WHERE Zavod_id='$table'";
 } 
 else {
	$query="UPDATE match_config SET
		Banka_ucet_CASTKA='$_POST[Banka_ucet_CASTKA]',
		Klub_web='$_POST[Klub_web]',
		Zavod='$_POST[Zavod]',
		Zavod_datum='$_POST[Zavod_datum]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_main_dopoledne='$_POST[Zavod_cas_main_dopoledne]',
		Zavod_cas_main_odpoledne='$_POST[Zavod_cas_main_odpoledne]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_poradatel='$_POST[Zavod_poradatel]',
		Zavod_poradatel_adresa='$_POST[Zavod_poradatel_adresa]',
		Zavod_match_director='$_POST[Zavod_match_director]',
		Zavod_email_poradatel='$_POST[Zavod_email_poradatel]',
		Zavod_telefon_poradatel='$_POST[Zavod_telefon_poradatel]',
		Zavod_range_master='$_POST[Zavod_range_master]',
		Zavod_email_range_master='$_POST[Zavod_email_range_master]',
		Zavod_telefon_range_master='$_POST[Zavod_telefon_range_master]',
		Zavod_stats='$_POST[Zavod_stats]',
		Zavod_email_stats='$_POST[Zavod_email_stats]',
		Zavod_telefon_stats='$_POST[Zavod_telefon_stats]',
		Zavod_hospodar='$_POST[Zavod_hospodar]',
		Zavod_email_hospodar='$_POST[Zavod_email_hospodar]',
		Zavod_telefon_hospodar='$_POST[Zavod_telefon_hospodar]',
		Zavod_email_from='$_POST[Zavod_email_from]',
		Zavod_stages='$_POST[Zavod_stages]',
		Zavod_min_pocet_ran='$_POST[Zavod_min_pocet_ran]',
		Zavod_pocet_dni_na_platbu='$_POST[Zavod_pocet_dni_na_platbu]',
		Zavod_vysledky='$_POST[Zavod_vysledky]',
		Squad_main_max='$_POST[Squad_main_max]',
		Squad_prem_max='$_POST[Squad_prem_max]'
	WHERE Zavod_id='$table'";
}

$result = mysql_query($query);
if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
	}
else {
	header("refresh:0;url=index.php");
}
}
// KONFIGRACE ZAVODU


// PRIDANI NOVEHO ZAVODNIKA
if (isset($_GET[new_shooter])) {
  $varsymbol=substr(rand(),0,4);
  $alias=trim(mb_convert_case($_POST[Alias], MB_CASE_UPPER, "UTF-8"));
  $jmeno=trim(mb_convert_case($_POST[Jmeno], MB_CASE_TITLE, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[Prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[Prijmeni_stav].'';
  $prijmeni=ucfirst(strtolower($prijmeni));
  $ip=($_SERVER["REMOTE_ADDR"]." - admin");

  //kontrola, zda je závodnik s aliasem nebo jmenem a primenim uz zaregistrovan (bez vyřazených)
  $check="SELECT * FROM $table WHERE ((Alias = '$alias') OR (Jmeno = '$jmeno' AND Prijmeni = '$prijmeni')) AND Squad>=100";
  $check_z=mysql_query($check);
  $zavodnik=mysql_fetch_array($check_z);

	if ($prijmeni==$zavodnik[Prijmeni] AND $jmeno==$zavodnik[Jmeno]){
	echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
		</div>
		<div class='modal-body'>
			<p class='font-weight-bold'>Závodník $jmeno $prijmeni už je zaregistrovaný. Zkontrolujte seznam závodníků</p>
			<p class='font-italic'>Pokud nejde o chybu, upravte příjmení $prijmeni např. na <b>$prijmeni"."1</b> nejlépe bez mezery)</b>"." nebo z nabídky zvolte <b>ml./st.</b></p>
			<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:16px'></i>Po kliknutí na tlačítko <kbd>Zpět</kbd> se vrátíte do administrace závodu (údaje zadané do formuláře zůstanou vyplněné - stačí kliknout znovu <kbd>Přidat nového závodníka</kbd>).</p>
		</div>
		<div class='modal-footer'>
			<button class='btn btn-primary waves-effect waves-light' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>
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
		die();
	}
	if ($alias==$zavodnik[Alias]){
	echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
		</div>
		<div class='modal-body'>
			<p class='font-weight-bold'>Závodník s aliasem $alias už je zaregistrovaný. Zkontrolujte seznam závodníků</p>
			<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:16px'></i>Po kliknutí na tlačítko <kbd>Zpět</kbd> se vrátíte do administrace závodu (údaje zadané do formuláře zůstanou vyplněné - stačí kliknout znovu <kbd>Přidat nového závodníka</kbd>).</p>
		</div>
		<div class='modal-footer'>
			<button class='btn btn-primary waves-effect waves-light' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>
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
		die();
	}
  //konec kontroly, zda je závodnik s aliasem nebo jmenem a primenim uz zaregistrovan (bez vyřazených)

else
{
  $query = "SELECT * from match_config where Zavod_id='$table'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $match_data = mysql_fetch_array($result);
   $query="INSERT INTO ".$table." (Alias,Jmeno,Prijmeni,VarSym,Region,Mail,Kategorie,Pidiv,Pifak,Squad,DatReg,RegistraceIP,Staff,ZaplatiNaMiste,Poznamka,Zavod)
  VALUES (
  '$alias',
  '$jmeno',
  '$prijmeni',
  '$varsymbol',
  '$_POST[Region]',
  '$_POST[Mail]',
  '$_POST[Kategorie]',
  '$_POST[Pidiv]',
  '$_POST[Pifak]',
  '$_POST[Squad]',
  '$_POST[datreg]',
  '$ip',
  NULLIF('$_POST[Staff]',''),
  NULLIF('$_POST[ZaplatiNaMiste]',''),
  NULLIF('$_POST[Poznamka]',''),
  '$table'
  )";

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
	header("refresh:0;url=index.php");
};

// nastaveni identifikatoru (klice) a datumu zaplaceni
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and VarSym='$varsymbol' and  Mail='$_POST[Mail]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);

  $prematch_datum=date('Y-m-d', strtotime("-1 day", strtotime($match_data[Zavod_datum])));
  $DatReg=date('d.m.Y', $z[DatReg]);
  $payLimit=$match_data[Zavod_pocet_dni_na_platbu];

  // Převod datumů na objekty typu DateTime
  $prematchDateTime = new DateTime($prematch_datum);
  $regDateTime = new DateTime($datReg);

  // Odčítání 10 dní od datumu konani prematche
  $prematchDateTime->modify("-$payLimit days");

  if ($regDateTime >= $prematchDateTime) {
      $DatPay=date('d.m.Y', strtotime("-2 day", strtotime($match_data[Zavod_datum])));
  } else {
  	  $DatPay=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", strtotime($DatReg)));
  }

  $result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)),DatPay='$DatPay' where klic is null or klic=0;");

// Zaslani potvrzeni registrace a platebnich udaju zavodnihovi s odkazy na spravu ucasti (zruseni)
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and VarSym='$varsymbol' and Mail='$_POST[Mail]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
  $squad=$nazvy_squadu[$z[Squad]];

  $tyden=intval(date("W",strtotime($zavod_datum)));
  $varsymbol_new="$tyden".($z[Cislo]); //prefix "18" pro var.symbol pistole.  
  $query="update ".$table." set VarSym='$varsymbol_new' where VarSym='$varsymbol'";
  $res=mysql_query($query);
  $varsymbol=$varsymbol_new;
  $dnes=date_format(new DateTime(),"Y-m-d");
  $mena=$match_data[Banka_ucet_MENA];

   if ($z[Staff]=="RO") {
     $Rozhodci="ANO";
   } else {
     $Rozhodci="NE";
   }
   if ($z[Staff]=="POM") {
     $Pomocnik="ANO";
   } else {
     $Pomocnik="NE";
   }

	if (($z[Staff]=="VIP") or ($z[Staff]=="RO") or ($z[Staff]=="POM")){
		$query="UPDATE ".$table." SET Zaplaceno='on' ,Castka='0',Mena='$mena',DatumZaplaceni='$dnes' where Cislo='$z[Cislo]' and klic='$z[klic]'";
		$res=mysql_query($query);
		$message=$email_registrace_bez_platby_text_admin_novy_zavodnik;
	}	elseif ($z[Squad]=="-2"){
 		$message=$email_registrace_cekatel_text_admin_novy_zavodnik;
	}	elseif ($z[ZaplatiNaMiste]=="on"){
 		$message=$email_registrace_platba_na_miste_admin_novy_zavodnik;
	}	elseif ($match_data[Payment_before]==""){
 		$message=$email_registrace_zavod_bez_platby_predem_admin_novy_zavodnik;
	}	else {
		$message=$email_registrace_platba_text_admin_novy_zavodnik;
	}
	
  $link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]'><strong>zrušit účast</strong></a>";

// priprava podkladu pro email zavodnikovi
  $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
  $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="Divize: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
  $STRELEC.="Squad: $squad"."\r\n\r\n";
  $STRELEC.="<i>Rozhodčí: $Rozhodci"."\r\n";
  $STRELEC.="Pomocník: $Pomocnik</i>"."\r\n";

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$_POST[Mail];
  $subject = "Registrace ".$match_data[Zavod];

  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při odeslání emailu došlo k chybě. Jestliže je závodník přidaný, zkuste poslat email ručně pomocí modrého tlačítka 'Poslat závodníkovi registrační email'.</p>";
	echo "<button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
}
else
// zapiseme do DB, ze registracni mail byl odeslan
  $query_odeslano="UPDATE ".$table." SET OdeslanRegMail='1' WHERE VarSym='$varsymbol' and Mail='$_POST[Mail]' AND OdeslanRegMail IS NULL";
  $res3=mysql_query($query_odeslano);
};

};
// KONEC PRIDANI NOVEHO ZAVODNIKA


// EDITACE ZAVODNIKA
if (isset($_GET[edit_shooter])) {
  $alias=trim(mb_convert_case($_POST[Alias], MB_CASE_UPPER, "UTF-8"));
  $jmeno=trim(mb_convert_case($_POST[Jmeno], MB_CASE_TITLE, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[Prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[Prijmeni_stav].'';
  $prijmeni=ucfirst(strtolower($prijmeni));
  $dnes=date_format(new DateTime(),"Y-m-d");
  $mena=$match_data[Banka_ucet_MENA];

if (($_POST[Staff]=="VIP") or ($_POST[Staff]=="RO") or ($_POST[Staff]=="POM")){
$query="UPDATE ".$table." SET
  Alias='$alias',
  Jmeno='$jmeno',
  Prijmeni='$prijmeni',
  Mail='$_POST[Mail]',
  Pidiv='$_POST[Pidiv]',
  Kategorie='$_POST[Kategorie]',
  Pifak='$_POST[Pifak]',
  Region='$_POST[Region]',
  Squad='$_POST[Squad]',
  Staff='$_POST[Staff]',
  Zaplaceno='on',
  Castka='0',
  Mena='$mena',
  ZaplatiNaMiste=NULLIF('$_POST[ZaplatiNaMiste]',''),
  Poznamka='$_POST[Poznamka]'
 WHERE Cislo='$_POST[shooterID]'";
$result = mysql_query($query);
	}
		
else  {
$query="UPDATE ".$table." SET
  Alias='$alias',
  Jmeno='$jmeno',
  Prijmeni='$prijmeni',
  Mail='$_POST[Mail]',
  Pidiv='$_POST[Pidiv]',
  Kategorie='$_POST[Kategorie]',
  Pifak='$_POST[Pifak]',
  Region='$_POST[Region]',
  Squad='$_POST[Squad]',
  Staff='$_POST[Staff]',
  Zaplaceno=NULLIF('$_POST[Staff]',''),
  Mena='$mena',
  ZaplatiNaMiste=NULLIF('$_POST[ZaplatiNaMiste]',''),
  Poznamka='$_POST[Poznamka]'
 WHERE Cislo='$_POST[shooterID]'";
$result = mysql_query($query);
	}

if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}
	else {
		header("refresh:0;url=index.php");
		exit;
	}
}
// KONEC EDITACE ZAVODNIKA


// MAZANI ZAVODNIKA
if (isset($_GET[delete_shooter])) {
	$shooterID=intval($_POST[ID]);
	$query="DELETE FROM ".$table." WHERE Cislo=$_POST[shooterID]";
	$result = mysql_query($query);

if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}
if ($result) {
	header("refresh:0;url=index.php");
	exit;
}
// pri smazani zavodnika se neposila mail
}
// KONEC MAZANI ZAVODNIKA

// VYRAZENI ZAVODNIKA
if (isset($_GET[cancel_shooter])) {
$dnes=date_format(new DateTime(),"Y-m-d");
$ip=($_SERVER["REMOTE_ADDR"]." - admin");

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
if ($result) {
	header("refresh:0;url=index.php");
}
// posilame mail zavodnikovi
$query="select * from $table where Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$strelci=mysql_query($query);
$z=mysql_fetch_array($strelci);

   $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
   $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
   $STRELEC.="Divize: $z[Pidiv] $z[Pifak]"."\r\n";

   $from_text="";
   $from=$match_data[Zavod_email_from];
   $to=$z[Mail];
   $subject = "Zrušení registrace závodníka ".$match_data[Zavod];
   $message=$email_text_vyrazeni_admin;
   $message=str_replace("##STRELEC##", $STRELEC, $message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při odeslání emailu došlo k chybě. Zkuste to později.</p>";
	echo "<button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
}
}
// KONEC VYRAZENI ZAVODNIKA


// EVIDENCE UHRADY PLATBY
if (isset($_GET[mark_paid])) {
$dnes=date_format(new DateTime(),"Y-m-d");
$query="select * from $table WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result=mysql_query($query);
if (!$result) {
  die('<strong><FONT COLOR=RED>Nelze dohledat střelce</FONT></strong>');
}

$query="UPDATE ".$table." 
 SET 
    Zaplaceno='on',
    Castka='$match_data[Banka_ucet_CASTKA]',
    Mena='$match_data[Banka_ucet_MENA]',
    DatumZaplaceni='$dnes'
  WHERE 
    Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";

$result = mysql_query($query);
if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}
if ($result) {
	header("refresh:0;url=index.php");
}
// posilame mail zavodnikovi
$query="select * from $table where Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$strelci=mysql_query($query);
$z=mysql_fetch_array($strelci);

   $squad=$nazvy_squadu[$z[Squad]];
   $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
   $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
   $STRELEC.="Divize: $z[Pidiv] $z[Pifak]"."\r\n";
   $STRELEC.="Squad: $squad"."\r\n";

   $from_text="";
   $from=$match_data[Zavod_email_from];
   $to=$z[Mail];
   $subject = "Evidence platby ".$match_data[Zavod];
   $message=$email_text_platba;      
   $message=str_replace("##STRELEC##", $STRELEC, $message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při odeslání emailu došlo k chybě. Zkuste to později.</p>";
	echo "<button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
}
}
// KONEC EVIDENCE UHRADY PLATBY


// PLACENI ZAVODU NA MISTE
if (isset($_GET[payment_before_off])) {
	$query="update match_config set Payment_before='', Zavod_pocet_dni_na_platbu='365' where Zavod_id='$table'";
	$result = mysql_query($query);

if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}
if ($result) {
	header("refresh:0;url=index.php");
	exit;
}
}
// PLACENI ZAVODU NA MISTE

// PLACENI ZAVODU do 10 dnu od registrace
if (isset($_GET[payment_before_on])) {
	$query="update match_config set Payment_before='on', Zavod_pocet_dni_na_platbu='10' where Zavod_id='$table'";
	$result = mysql_query($query);

if (!$result) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Zkuste to později nebo zkontaktujte správce aplikace.</p>";
	echo "<pre>MySQL Error: ". mysql_error();"</pre>";
	echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
	exit;
}
if ($result) {
	header("refresh:0;url=index.php");
	exit;
}
}
// PLACENI ZAVODU do 10 dnu od registrace

?>
