    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<?php 
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit();
}

if (file_exists('./db/dbconn.php')) {
    include './db/dbconn.php';
} elseif (file_exists('../db/dbconn.php')) {
    include '../db/dbconn.php';
}

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
		Zavod_cas_registrace='$_POST[Zavod_cas_registrace]',
		Zavod_zacatek_registrace='$_POST[Zavod_zacatek_registrace]',
		Zavod_konec_registrace='$_POST[Zavod_konec_registrace]',
		Zavod_registrace_pozastaveno='$_POST[Zavod_registrace_pozastaveno]',
		Zavod_more_divisions='$_POST[Zavod_more_divisions]',
		Zavod_zobrazovat_sponzory='$_POST[Zavod_zobrazovat_sponzory]',
		Zavod_zbrojni_prukaz='$_POST[Zavod_zbrojni_prukaz]',
		Web_zobrazovat_situace='$_POST[Web_zobrazovat_situace]',
		Web_zobrazovat_aliasy='$_POST[Web_zobrazovat_aliasy]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_main_dopoledne='$_POST[Zavod_cas_main_dopoledne]',
		Zavod_cas_main_odpoledne='$_POST[Zavod_cas_main_odpoledne]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_misto_mapa='$_POST[Zavod_misto_mapa]',
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
		Squad_prem_max='$_POST[Squad_prem_max]',
		Payment_before='$_POST[Payment_before]'
	WHERE Zavod_id='$table'";
 } 
 else {
	$query="UPDATE match_config SET
		Banka_ucet_CASTKA='$_POST[Banka_ucet_CASTKA]',
		Klub_web='$_POST[Klub_web]',
		Zavod='$_POST[Zavod]',
		Zavod_datum='$_POST[Zavod_datum]',
		Zavod_registrace_pozastaveno='$_POST[Zavod_registrace_pozastaveno]',
		Zavod_more_divisions='$_POST[Zavod_more_divisions]',
		Zavod_zobrazovat_sponzory='$_POST[Zavod_zobrazovat_sponzory]',
		Zavod_zbrojni_prukaz='$_POST[Zavod_zbrojni_prukaz]',
		Web_zobrazovat_situace='$_POST[Web_zobrazovat_situace]',
		Web_zobrazovat_aliasy='$_POST[Web_zobrazovat_aliasy]',
		Zavod_cas_prematch='$_POST[Zavod_cas_prematch]',
		Zavod_cas_prezence='$_POST[Zavod_cas_prezence]',
		Zavod_cas_main='$_POST[Zavod_cas_main]',
		Zavod_cas_main_dopoledne='$_POST[Zavod_cas_main_dopoledne]',
		Zavod_cas_main_odpoledne='$_POST[Zavod_cas_main_odpoledne]',
		Zavod_misto='$_POST[Zavod_misto]',
		Zavod_misto_mapa='$_POST[Zavod_misto_mapa]',
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
		Squad_prem_max='$_POST[Squad_prem_max]',
		Payment_before='$_POST[Payment_before]'
	WHERE Zavod_id='$table'";
}

$result = mysql_query($query);

if ($result) {
	header("refresh:0;url=index.php");
	exit();
 }
else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
};
// KONFIGRACE ZAVODU


// PRIDANI NOVEHO ZAVODNIKA
if (isset($_GET[new_shooter])) {
  $varsymbol=substr(rand(),0,4);
  $alias=trim(mb_convert_case($_POST[Alias], MB_CASE_UPPER, "UTF-8")).mb_convert_case($_POST[Divize_dalsi], MB_CASE_UPPER);
  $jmeno=trim(mb_convert_case($_POST[Jmeno], MB_CASE_TITLE, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[Prijmeni], MB_CASE_TITLE, "UTF-8")).mb_convert_case($_POST[Divize_dalsi], MB_CASE_UPPER).$_POST[Prijmeni_stav].'';
  $ip=($_SERVER["REMOTE_ADDR"]." - admin");
  
  if ($_POST[Divize]=="") {
	$divize=substr("$_POST[Divize_dalsi]", 1);
	} else {
	$divize=$_POST[Divize];}

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
			<p class='font-weight-bold'>Závodník $jmeno $prijmeni už je zaregistrovaný.</p>
			<p>Pokud nejde o chybu, upravte příjmení $prijmeni např. na <b>$prijmeni"."1</b> nejlépe bez mezery)</b>"." nebo z nabídky zvolte <b>ml./st.</b></p>
			<p class='small text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:14px'></i>Kliknutím na tlačítko <strong>Zpět</strong> se vrátíte do administrace závodu.<BR>Údaje zadané do formuláře zůstanou vyplněné - stačí znovu použít tlačítko <br><strong>Přidat nového závodníka</strong>).</p>
		</div>
		<div class='modal-footer'>
			<button class='btn btn-danger waves-effect waves-light' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>
		</div>
		</div>
	</div>
	</div>
	";
	}
	elseif ($alias==$zavodnik[Alias]){
	echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
		</div>
		<div class='modal-body'>
			<p class='font-weight-bold'>Závodník s aliasem $alias už je zaregistrovaný.</p>
			<p>Zkontrolujte seznam závodníků</p>
			<p class='small text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:14px'></i>Kliknutím na tlačítko <strong>Zpět</strong> se vrátíte do administrace závodu.<BR>Údaje zadané do formuláře zůstanou vyplněné - stačí znovu použít tlačítko <br><strong>Přidat nového závodníka</strong>).</p>
		</div>
		<div class='modal-footer'>
			<button class='btn btn-danger waves-effect waves-light' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>
		</div>
		</div>
	</div>
	</div>
	";
	}
  //konec kontroly, zda je závodnik s aliasem nebo jmenem a primenim uz zaregistrovan (bez vyřazených)

else {
  $query = "SELECT * from match_config where Zavod_id='$table'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $match_data = mysql_fetch_array($result);
  
  $query="INSERT INTO ".$table." (Alias,Jmeno,Prijmeni,ZP,VarSym,Region,Mail,Kategorie,Divize,Faktor,Squad,DatReg,RegistraceIP,Staff,ZaplatiNaMiste,Poznamka,Zavod)
  VALUES (
  '$alias',
  '$jmeno',
  '$prijmeni',
  '$_POST[ZP]',
  '$varsymbol',
  '$_POST[Region]',
  '$_POST[Mail]',
  '$_POST[Kategorie]',
  '$divize',
  '$_POST[Faktor]',
  '$_POST[Squad]',
  '$_POST[datreg]',
  '$ip',
  NULLIF('$_POST[Staff]',''),
  NULLIF('$_POST[ZaplatiNaMiste]',''),
  NULLIF('$_POST[Poznamka]',''),
  '$table'
  )";

$result = mysql_query($query);

if ($result) {
	header("refresh:0;url=index.php");
 }
else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }

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
  
  $query="update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)),DatPay='$DatPay' where klic is null or klic=0";
  $result = mysql_query($query);


// Zaslani potvrzeni registrace a platebnich udaju zavodnihovi s odkazy na spravu ucasti (zruseni)
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and VarSym='$varsymbol' and Mail='$_POST[Mail]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
//  $squad=$nazvy_squadu[$z[Squad]]; //TO-DO získání squadůz databáze
  $squad=$z[Squad]; 

  $tyden=str_replace(' ','',$match_data[Zavod_datum]);
  $tyden=intval(date("W",strtotime($tyden)));
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
  $STRELEC.="Divize: $z[Divize] $z[Faktor]"."\r\n";
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
  $alias=trim(mb_convert_case($_POST[Alias], MB_CASE_UPPER, "UTF-8")).mb_convert_case($_POST[Divize_dalsi], MB_CASE_UPPER);
  $jmeno=trim(mb_convert_case($_POST[Jmeno], MB_CASE_TITLE, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[Prijmeni], MB_CASE_TITLE, "UTF-8")).mb_convert_case($_POST[Divize_dalsi], MB_CASE_UPPER).$_POST[Prijmeni_stav].'';
  $dnes=date_format(new DateTime(),"Y-m-d");
  $mena=$match_data[Banka_ucet_MENA];

if (($_POST[Staff]=="VIP") or ($_POST[Staff]=="RO") or ($_POST[Staff]=="POM")){
$query="UPDATE ".$table." SET
  Alias='$alias',
  Jmeno='$jmeno',
  Prijmeni='$prijmeni',
  ZP='$_POST[ZP]',
  Mail='$_POST[Mail]',
  Divize='$_POST[Divize]',
  Kategorie='$_POST[Kategorie]',
  Faktor='$_POST[Faktor]',
  Region='$_POST[Region]',
  Squad='$_POST[Squad]',
  Staff='$_POST[Staff]',
  Zaplaceno='on',
  Castka='0',
  Mena='$mena',
  ZaplatiNaMiste=NULLIF('$_POST[ZaplatiNaMiste]',''),
  Poznamka='$_POST[Poznamka]'
 WHERE Cislo='$_POST[shooterID]'";
 
}
		
else  {
$query="UPDATE ".$table." SET
  Alias='$alias',
  Jmeno='$jmeno',
  Prijmeni='$prijmeni',
  ZP='$_POST[ZP]',
  Mail='$_POST[Mail]',
  Divize='$_POST[Divize]',
  Kategorie='$_POST[Kategorie]',
  Faktor='$_POST[Faktor]',
  Region='$_POST[Region]',
  Squad='$_POST[Squad]',
  Staff='$_POST[Staff]',
  Zaplaceno=NULLIF('$_POST[Zaplaceno]',''),
  Mena='$mena',
  ZaplatiNaMiste=NULLIF('$_POST[ZaplatiNaMiste]',''),
  Poznamka='$_POST[Poznamka]'
 WHERE Cislo='$_POST[shooterID]'";
};

$result = mysql_query($query);

if (!$result) {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
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
exit();
}
	
	
// přesun cekatele do squadu

if (($_POST[Squad_old]=="-2") AND ($_POST[Squad_old]!=$_POST[Squad])){
	
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and Mail='$_POST[Mail]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
//  $squad=$nazvy_squadu[$z[Squad]];
  $squad=$z[Squad];

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

  $dnes=date_format(new DateTime(),"Y-m-d");
  $mena=$match_data[Banka_ucet_MENA];
  $message=$email_registrace_cekatel_presun_platba;
  $link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]'><strong>zrušit účast</strong></a>";

// priprava podkladu pro email zavodnikovi
  $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
  $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="Divize: $z[Divize] $z[Faktor]"."\r\n";
  $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
  $STRELEC.="Squad: $squad"."\r\n\r\n";

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$_POST[Mail];
  $subject = "Registrace ".$match_data[Zavod];

  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##Squad##",$squad,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

  $send_email = email($from_text,$from,$to,$subject, $message);

  if ($send_email) {

  echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-success text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Přesun závodníka z čekatelů</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-success'>Závodník byl přeřazen do běžného squadu.</p>
			<p class='text-center small mb-0 mx-3'><i class='fa fa-info-circle pr-1' style='font-size:16px'></i>Registrační email s podklady pro zaplacení byl odeslán na adresu $_POST[Mail] zadanou při registraci.</p>
		</div>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-success'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
  }
 else {
  echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba odeslání emailu</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-2 '>Při odeslání registračního emailu došlo k chybě!</p>
			<p class='text-center small '>Pošlete email z administrace pomocí tlačítka <i class='fa fa-envelope pr-1' style='font-size:16px; color: #007bff'></i><b>Poslat závodníkovi registrační email</b> nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
  }

}

else {
	header("refresh:0;url=index.php");
	exit();
}

};
// přesun cekatele do squadu

// KONEC editace


// MAZANI ZAVODNIKA
if (isset($_GET[delete_shooter])) {
	$shooterID=intval($_POST[ID]);
	$query="DELETE FROM ".$table." WHERE Cislo=$_POST[shooterID]";
	$result = mysql_query($query);

if ($result) {
	header("refresh:0;url=index.php");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
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

if ($result) {
$query="UPDATE ".$table." SET SquadReg='$line[Squad]',Squad='-9',Vyrazeno='$dnes',VyrazenoIP='$ip' WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result = mysql_query($query);
	header("refresh:0;url=index.php");
}

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
}

// posilame mail zavodnikovi
$query="select * from $table where Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$strelci=mysql_query($query);
$z=mysql_fetch_array($strelci);

   $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
   $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
   $STRELEC.="Divize: $z[Divize] $z[Faktor]"."\r\n";

   $from_text="";
   $from=$match_data[Zavod_email_from];
   $to=$z[Mail];
   $subject = "Zrušení registrace závodníka ".$match_data[Zavod];
   $message=$email_text_vyrazeni_admin;
   $message=str_replace("##STRELEC##", $STRELEC, $message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
  echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba odeslání emailu</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-2 '>Při odeslání emailu došlo k chybě!</p>
			<p class='text-center small '>kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
";
	}
}
// KONEC VYRAZENI ZAVODNIKA


// EVIDENCE UHRADY PLATBY
if (isset($_GET[mark_paid])) {
$dnes=date_format(new DateTime(),"Y-m-d");
$query="select * from $table WHERE Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$result=mysql_query($query);

if (!$result) {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Nebylo možné dohledat střelce!</p>
			<p class='text-center small'>Vraťte se zpět do administrace a zkontrolujte, zda nebyl mezitím smazán nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
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
exit();
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
if ($result) {
	header("refresh:0;url=index.php");
}

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
}

// posilame mail zavodnikovi
$query="select * from $table where Cislo='$_POST[shooterID]' and klic='$_POST[shooterKEY]'";
$strelci=mysql_query($query);
$z=mysql_fetch_array($strelci);

//   $squad=$nazvy_squadu[$z[Squad]];
   $squad=$z[Squad];
   $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
   $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
   $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
   $STRELEC.="Divize: $z[Divize] $z[Faktor]"."\r\n";
   $STRELEC.="Squad: $squad"."\r\n";

   $from_text="";
   $from=$match_data[Zavod_email_from];
   $to=$z[Mail];
   $subject = "Evidence platby ".$match_data[Zavod];
   $message=$email_text_platba;      
   $message=str_replace("##STRELEC##", $STRELEC, $message);

$send_email = email($from_text,$from,$to,$subject, $message);
if (!$send_email) {
  echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba odeslání emailu</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-2 '>Při odeslání emailu došlo k chybě!</p>
			<p class='text-center small '>kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
// KONEC EVIDENCE UHRADY PLATBY


// // PLACENI ZAVODU NA MISTE
// if (isset($_GET[payment_before_off])) {
// //  $query="update match_config set Payment_before='', Zavod_pocet_dni_na_platbu='365' where Zavod_id='$table'";
//   $query="update match_config set Payment_before='' where Zavod_id='$table'";
//   $result = mysql_query($query);
// 
// if ($result) {
// 	header("refresh:0;url=index.php");
// 	exit;
//  }
// 
// else {
//  echo "
// 	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
// 	 <div class='modal-dialog'>
// 		<div class='modal-content'>
// 		   <div class='modal-header bg-danger text-center'>
// 			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
// 		   </div>
// 		<div class='modal-body'>
// 			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
// 			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
// 		<div class='modal-footer border-top-0 mt-2'>
// 			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
// 		</div>
// 	  </div>
// 	 </div>
// 	</div>
// 	";
//  }
// };
// // PLACENI ZAVODU NA MISTE
// 
// // PLACENI ZAVODU do 10 dnu od registrace
// if (isset($_GET[payment_before_on])) {
//   $query="update match_config set Payment_before='on' where Zavod_id='$table'";
// //  $query="update match_config set Payment_before='on', Zavod_pocet_dni_na_platbu='10' where Zavod_id='$table'";
//   $result = mysql_query($query);
// 
// if ($result) {
// 	header("refresh:0;url=index.php");
// 	exit;
//  }
// 
// else {
//  echo "
// 	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
// 	 <div class='modal-dialog'>
// 		<div class='modal-content'>
// 		   <div class='modal-header bg-danger text-center'>
// 			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
// 		   </div>
// 		<div class='modal-body'>
// 			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
// 			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
// 		<div class='modal-footer border-top-0 mt-2'>
// 			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
// 		</div>
// 	  </div>
// 	 </div>
// 	</div>
// 	";
//  }
// }
// // PLACENI ZAVODU do 10 dnu od registrace


// SPRÁVA DIVIZÍ

// NOVA DIVIZE
if (isset($_GET[new_division])) {
	 $name = $_POST['Name'];
	 $value = $_POST['Value'];
	 $query = "INSERT INTO $table_divisions (Name,Value)
	 VALUES ('$name','$value')";
	 $result = mysql_query($query);

if ($result) {
	header("Location: index.php?divisions");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC NOVA DIVIZE

// MAZANI DIVIZE
if (isset($_GET[delete_division])) {
	$query = "DELETE FROM $table_divisions WHERE Name='" . $_GET["pidiv"] . "'";
	$result = mysql_query($query);


if ($result) {
	    header("Location: index.php?divisions");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujtekontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC MAZANI DIVIZE


// SPRÁVA KATEGORIE

// NOVA KATEGORIE
if (isset($_GET[new_category])) {
	 $name = $_POST['Name'];
	 $value = $_POST['Value'];
	 $query = "INSERT INTO $table_categories (Name)
	 VALUES ('$name')";
	 $result = mysql_query($query);

if ($result) {
	header("Location: index.php?categories");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC NOVA KATEGORIE

// MAZANI KATEGORIE
if (isset($_GET[delete_category])) {
	$query = "DELETE FROM $table_categories WHERE Name='" . $_GET["category"] . "'";
	$result = mysql_query($query);


if ($result) {
	header("Location: index.php?categories");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC MAZANI KATEGORIE


// SPRÁVA SQUADŮ

// NOVY SQUAD
if (isset($_GET[new_squad])) {
	 $number = $_POST['Number'];
	 $name = $_POST['Name'];
	 $query = "INSERT INTO $table_squads (Number,Name)
	 VALUES ('$number','$name')";
	 $result = mysql_query($query);

if ($result) {
	header("Location: index.php?squads");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC NOVY SQUAD

// MAZANI SQUADU
if (isset($_GET[delete_squad])) {
	$query = "DELETE FROM $table_squads WHERE Number='" . $_GET["squadNumber"] . "'";
	$result = mysql_query($query);


if ($result) {
	header("Location: index.php?squads");
	exit();
 }

else {
 echo "
	<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	 <div class='modal-dialog'>
		<div class='modal-content'>
		   <div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold' id='exampleModalLabel'>Chyba databáze</h4>
		   </div>
		<div class='modal-body'>
			<p class='text-center font-weight-bolder text-danger mb-3 '>Při vkládání do databáze došlo k chybě!</p>
			<p class='text-center small'>Zkuste to později nebo kontaktujte <a href='mailto:$vyvojar?subject=$match_data[Zavod] - chyba aktualizace databáze [$table]'>správce aplikace</a>.</p>
		<div class='modal-footer border-top-0 mt-2'>
			<a href='./index.php' rel='modal:close'><button type='button' class='btn btn-danger'>Zpět do administrace</button></a>
		</div>
	  </div>
	 </div>
	</div>
	";
 }
}
 // KONEC MAZANI SQUADU



?>

<script  type='text/javascript'>
var myModal = new bootstrap.Modal(document.getElementById('regInfo'));
	myModal.show();
	backdrop: 'static',
	keyboard: 'false'
</script>

<script  type='text/javascript'>
	$('#regInfo').modal({
		backdrop: 'static',
		keyboard: 'false'
	})
</script>
