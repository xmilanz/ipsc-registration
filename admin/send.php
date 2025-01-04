<?php
require_once ("../db/dbconn.php");
require_once ("functions.php");

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);

// REGISTRACNI MAIL
if (isset($_GET[regmail])) {
$query="select * from $table where Cislo=$_POST[shooterID]";
$strelec=mysql_query($query);
$z=mysql_fetch_array($strelec);
$squad=$nazvy_squadu[$z[Squad]];
$varsymbol=$z[VarSym];
$link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

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


// priprava podkladu pro email zavodnikovi
  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="SQUAD: $squad"."\r\n";
  $STRELEC.="ROZHODČÍ: $Rozhodci"."\r\n";
  $STRELEC.="POMOCNIK: $Pomocnik"."\r\n";

  $DatReg=date('d.m.Y', $z["DatReg"]);
  $DatPay=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", $z["DatReg"]));

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$z[Mail];
  $subject = "Registrace ".$match_data[Zavod];

//to-do check odeslani mailu pri platbe na miste
	if (($z[VIP]=="on") or ($z[RO]=="on") or ($z[POM]=="on")){
		$message=$email_registrace_bez_platby_text_admin;
	}	elseif ($z[Squad]=="-2"){
 		$message=$email_registrace_cekatel_text_admin;
	}	elseif ($z[ZaplatiNaMiste]=="on"){
 		$message=$email_registrace_platba_na_miste_admin;
	} elseif ($match_data[Payment_before]==""){
 		$message=$email_registrace_zavod_bez_platby_predem_admin;
	} else {
		$message=$email_registrace_platba_text_admin;
	}

  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při odeslání emailu došlo k chybě. Zkuste to později.</p>";
	echo "<button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
}
else {
	$query_odeslano="update ".$table." set OdeslanRegMail='1' where Mail='$z[Mail]' and OdeslanRegMail is null";
	$res3=mysql_query($query_odeslano);
	if (!$res3) {
		echo "<center>";
		echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Email však byl odeslán.</p>";
		echo "<pre>MySQL Error: ". mysql_error();"</pre>";
		echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
		echo "</center>";
	}
		else {
			header("refresh:0;url=index.php");
		}
}
}
// REGISTRACNI MAIL


// URGENCE PLATBY
if (isset($_GET[paymail])) {
$query="select * from $table where Cislo=$_POST[shooterID]";
$strelec=mysql_query($query);
$z=mysql_fetch_array($strelec);
$squad=$nazvy_squadu[$z[Squad]];
$varsymbol=$z[VarSym];
$link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

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

// priprava podkladu pro email zavodnikovi
  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="KATEGORIE: $z[Kategorie]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="SQUAD: $squad"."\r\n";
  $STRELEC.="ROZHODČÍ: $Rozhodci"."\r\n";
  $STRELEC.="POMOCNIK: $Pomocnik"."\r\n";

  $DatReg=date('d.m.Y', $z["DatReg"]);
  $DatPay=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", $z["DatReg"]));

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$z[Mail];
  $subject = "Chybějící platba ".$match_data[Zavod];

  $message=$email_urgence_platba_text_admin;
  $message=str_replace("##ALIAS##",$STRELEC,$message);
  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatReg##",$DatReg,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
	echo "<center>";
	echo"<p style='color:#ff0000;font-weight:bolder;'>Při odeslání emailu došlo k chybě. Zkuste to později.</p>";
	echo "<button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
	echo "</center>";
}
else {
  $dnes=date_format(new DateTime(),"Y-m-d");
  $query_odeslano="UPDATE ".$table." SET Urgence='$dnes' where Cislo=$_POST[shooterID]";
  $res3=mysql_query($query_odeslano);
	if (!$res3) {
		echo "<center>";
		echo"<p style='color:#ff0000;font-weight:bolder;'>Při vkládání do databáze došlo k chybě. Email však byl odeslán.</p>";
		echo "<pre>MySQL Error: ". mysql_error();"</pre>";
		echo "<br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"window.location.href = 'index.php';\">Zpět</button>";
		echo "</center>";
	}
	else {
		header("refresh:0;url=index.php");
		exit;
	}
}
}
// URGENCE PLATBY
?>