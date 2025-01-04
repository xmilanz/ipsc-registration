<?php 
    include ("../db/dbconn.php");

// KONFIGRACE ZAVODU
if (isset($_GET[match_config])) {
	
 if ($match_data[Payment_before]=="on"){
	$query="UPDATE match_config SET
		Banka_ucet_CASTKA='$_POST[Banka_ucet_CASTKA]',
		Banka_ucet_cislo='$_POST[Banka_ucet_cislo]',
		Banka_ucet_kod='$_POST[Banka_ucet_kod]',
		GDPR_spravce='$_POST[GDPR_spravce]',
		Klub_web='$_POST[Klub_web]',
		Squad_main_max='$_POST[Squad_main_max]',
		Squad_prem_max='$_POST[Squad_prem_max]',
		Zavod='$_POST[Zavod]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_datum='$_POST[Zavod_datum]',
		Zavod_email_from='$_POST[Zavod_email_from]',
		Zavod_email_hospodar='$_POST[Zavod_email_hospodar]',
		Zavod_email_poradatel='$_POST[Zavod_email_poradatel]',
		Zavod_hospodar='$_POST[Zavod_hospodar]',
		Zavod_match_director='$_POST[Zavod_match_director]',
		Zavod_min_pocet_ran='$_POST[Zavod_min_pocet_ran]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_pocet_dni_do_vyrazeni='$_POST[Zavod_pocet_dni_do_vyrazeni]',
		Zavod_pocet_dni_na_platbu='$_POST[Zavod_pocet_dni_na_platbu]',
		Zavod_poradatel='$_POST[Zavod_poradatel]',
		Zavod_range_master='$_POST[Zavod_range_master]',
		Zavod_stages='$_POST[Zavod_stages]',
		Zavod_stats='$_POST[Zavod_stats]',
		Zavod_telefon_poradatel='$_POST[Zavod_telefon_poradatel]',
		Zavod_telefon_hospodar='$_POST[Zavod_telefon_hospodar]',
		Zavod_vysledky='$_POST[Zavod_vysledky]'
	WHERE Zavod_id='$table'";
 } 
 else {
	$query="UPDATE match_config SET
		Banka_ucet_CASTKA='$_POST[Banka_ucet_CASTKA]',
		GDPR_spravce='$_POST[GDPR_spravce]',
		Klub_web='$_POST[Klub_web]',
		Squad_main_max='$_POST[Squad_main_max]',
		Squad_prem_max='$_POST[Squad_prem_max]',
		Zavod='$_POST[Zavod]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_datum='$_POST[Zavod_datum]',
		Zavod_email_from='$_POST[Zavod_email_from]',
		Zavod_email_hospodar='$_POST[Zavod_email_hospodar]',
		Zavod_email_poradatel='$_POST[Zavod_email_poradatel]',
		Zavod_hospodar='$_POST[Zavod_hospodar]',
		Zavod_match_director='$_POST[Zavod_match_director]',
		Zavod_min_pocet_ran='$_POST[Zavod_min_pocet_ran]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_poradatel='$_POST[Zavod_poradatel]',
		Zavod_range_master='$_POST[Zavod_range_master]',
		Zavod_stages='$_POST[Zavod_stages]',
		Zavod_stats='$_POST[Zavod_stats]',
		Zavod_telefon_poradatel='$_POST[Zavod_telefon_poradatel]',
		Zavod_telefon_hospodar='$_POST[Zavod_telefon_hospodar]',
		Zavod_vysledky='$_POST[Zavod_vysledky]'
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

  $query = "SELECT * from match_config where Zavod_id='$table'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $match_data = mysql_fetch_array($result);

   $query="INSERT INTO ".$table." (Alias,Jmeno,Prijmeni,VarSym,Region,Mail,Kategorie,Pidiv,Pifak,Squad,DatReg,RegistraceIP,RO,VIP,POM,ZaplatiNaMiste,Poznamka,OdeslanRegMail)
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
  '$_POST[RO]',
  '$_POST[VIP]',
  '$_POST[POM]',
  '$_POST[ZaplatiNaMiste]',
  '$_POST[Poznamka]',
  '1'
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

// nastaveni identifikatoru (klice)
$result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)) where klic is null or klic=0;");

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

  $mena=$banka_ucet_MENA;

   if ($z[RO]=="on") {
     $Rozhodci="ANO";
   } else {
     $Rozhodci="NE";
   }
   if ($z[POM]=="on") {
     $Pomocnik="ANO";
   } else {
     $Pomocnik="NE";
   }

	if (($z[VIP]=="on") or ($z[RO]=="on") or ($z[POM]=="on")){
		$query="UPDATE ".$table." SET Zaplaceno='on' ,Castka='0',Mena='$mena',DatumZaplaceni='$dnes' where Cislo='$z[Cislo]' and klic='$z[klic]'";
		$res=mysql_query($query);
		$message=$email_registrace_bez_platby_text_admin;
	}	elseif ($z[Squad]=="-2"){
 		$message=$email_registrace_cekatel_text_admin;
	}	elseif ($z[ZaplatiNaMiste]=="on"){
 		$message=$email_registrace_platba_na_miste_admin;
	}	elseif ($match_data[Payment_before]==""){
 		$message=$email_registrace_zavod_bez_platby_predem_admin;
	}	else {
		$message=$email_registrace_platba_text_admin;
	}
	
  $link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

// priprava podkladu pro email zavodnikovi
  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
  $STRELEC.="SQUAD: $squad"."\r\n";
  $STRELEC.="ROZHODČÍ: $Rozhodci"."\r\n";
  $STRELEC.="POMOCNÍK: $Pomocnik"."\r\n";

  $DatReg=date('d.m.Y', $z["DatReg"]);
  $DatPay=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", $z["DatReg"]));
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
};
// KONEC PRIDANI NOVEHO ZAVODNIKA


// EDITACE ZAVODNIKA
if (isset($_GET[edit_shooter])) {
  $alias=trim(mb_convert_case($_POST[Alias], MB_CASE_UPPER, "UTF-8"));
  $jmeno=trim(mb_convert_case($_POST[Jmeno], MB_CASE_TITLE, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[Prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[Prijmeni_stav].'';
  $prijmeni=ucfirst(strtolower($prijmeni));

$query="UPDATE ".$table." SET
  Alias='$alias',
  Jmeno='$jmeno',
  Prijmeni='$prijmeni',
  Mail='$_POST[Mail]',
  Pidiv='$_POST[Pidiv]',
  Kategorie='$_POST[Kategorie]',
  Pifak='$_POST[Pifak]',
  Squad='$_POST[Squad]',
  RO='$_POST[RO]',
  POM='$_POST[POM]',
  VIP='$_POST[VIP]',
  ZaplatiNaMiste='$_POST[ZaplatiNaMiste]',
  Poznamka='$_POST[Poznamka]'
 WHERE Cislo='$_POST[shooterID]'";

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
if (!$strelec=mysql_fetch_array($result)) {
  die('<strong><FONT COLOR=RED>Nelze dohledat závodníka</FONT></strong>');
}

$query="UPDATE ".$table." SET Squad='-9',Vyrazeno='$dnes',VyrazenoIP='$ip' WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
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
//$squad=$nazvy_squadu[$z[Squad]];

   $STRELEC="ALIAS: $z[Alias]"."\r\n";
   $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
   $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";

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
if (!$strelec=mysql_fetch_array($result)) {
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
   $STRELEC="ALIAS: $z[Alias]"."\r\n";
   $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
   $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
   $STRELEC.="SQUAD: $squad"."\r\n";

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
	$query="update match_config set Payment_before='', Zavod_pocet_dni_na_platbu='365',Zavod_pocet_dni_do_vyrazeni='365' where Zavod_id='$table'";
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
	$query="update match_config set Payment_before='on', Zavod_pocet_dni_na_platbu='10',Zavod_pocet_dni_do_vyrazeni='13' where Zavod_id='$table'";
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
