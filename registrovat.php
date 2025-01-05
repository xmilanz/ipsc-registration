<?php
include "./header.php";

/* zkontrolovat max pocet ve squadu */
$squad_max=$match_data[Squad_main_max];
if ($_POST[squad]==100) {
  $squad_max=$match_data[Squad_prem_max];
}
$query = "SELECT Count(Prijmeni) FROM ".$table." WHERE Squad=\"".$_POST[squad]."\"";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$line = mysql_fetch_row($result);
$squad_pocet=$line[0];
if ($squad_pocet>=$squad_max) {
  echo "
  <div class='text-center'>
  	<img src='./images/EC_ASCII.png'>
  </div>
  <div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
        </div>
        <div class='modal-body'>
  		<p class='font-weight-bold'>Squad $_POST[squad] je zaplněný</p>
  		<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:16px'></i>Po kliknutí na tlačítko <kbd>Zpět</kbd> se vraťte do registrace a zvolte nezaplněný squad.</p>
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
}

else {
  $varsymbol=substr(rand(),0,4);
  $alias=trim(mb_convert_case($_POST[alias], MB_CASE_UPPER, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[prijmeni_stav].'';
  $prijmeni = ucfirst(strtolower($prijmeni));
  $jmeno=trim(mb_convert_case($_POST[jmeno], MB_CASE_TITLE, "UTF-8"));

$ip=$_SERVER["REMOTE_ADDR"];

//kontrola, zda je závodnik s aliasem nebo jmenem a primenim uz zaregistrovan (bez vyřazených)
$check="SELECT * FROM $table WHERE ((Alias = '$alias') OR (Jmeno = '$jmeno' AND Prijmeni = '$prijmeni')) AND Squad>=100";
$check_z=mysql_query($check);
$zavodnik=mysql_fetch_array($check_z);

if ($prijmeni==$zavodnik[Prijmeni] AND $jmeno==$zavodnik[Jmeno]){
echo "
<div class='text-center'>
	<img src='./images/EC_ASCII.png'>
</div>
<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
      </div>
      <div class='modal-body'>
		<p class='font-weight-bold'>Závodník $jmeno $prijmeni už je zaregistrovaný</p>
		<p class='font-italic'>Buď vás už někdo zaregistroval nebo máte stejné jméno a příjmení jako jiný závodník :-) V&nbsp;tom případě napište pro odlišení za Vaše příjmení $prijmeni nějaký další znak (např. <b>$prijmeni"."1 nejlépe bez mezery)</b>"." nebo z nabídky zvolte <b>ml./st.</b></p>
		<p class='text-danger text-center mb-3 font-italic'><i class='far fa-exclamation-circle pr-2' style='font-size:16px'></i>Kombinaci <mark>Jméno Příjmení</mark> byste měli používat v průběhu celé série závodu.</p>
		<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:16px'></i>Kliknutím na tlačítko <kbd>Zpět</kbd> se vraťte na registraci (údaje zadané do formuláře v příslušném squadu budou stále vyplněné). Zvolte tedy znovu squad $_POST[squad] a upravte příjmení.</p>
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
<div class='text-center'>
	<img src='./images/EC_ASCII.png'>
</div>
<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h4 class='modal-title text-danger' id='exampleModalLabel'>Neúspěšná registrace</h4>
      </div>
      <div class='modal-body'>
		<p class='font-weight-bold'>Závodník s aliasem $alias už je zaregistrovaný</p>
		<p class='font-italic mb-3'>V případě, že jste zadali skutečně váš zaregistrovaný alias, zkontaktujte pořadatele.<br>Pokud jste zadali alias <strong>nezaregistrovaný na IPSC-TECH.ORG</strong>, použijte tento <a href='https://www.ipsc-tech.org/ics/hq/embdAliasReg.aspx' target='_new'>odkaz</a> a&nbsp;zaregistrujte se.</p>
		<p class='text-danger text-center mb-3 font-italic'><i class='far fa-exclamation-circle pr-2' style='font-size:16px'></i>V průběhu celé série závodu byste měli používat stále stejný <mark>alias</mark>.</p>
		<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-2' style='font-size:16px'></i>Kliknutím na tlačítko <kbd>Zpět</kbd> se vraťte na registraci (údaje zadané do formuláře v příslušném squadu budou stále vyplněné). Zvolte tedy znovu squad $_POST[squad] a opravte alias.</p>
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

else
{
  $query="INSERT INTO ".$table." (Alias,Prijmeni,Jmeno,VarSym,Region,Mail,Kategorie,Pidiv,Pifak,DatReg,RegistraceIP,Squad,Staff,Zavod) 
  VALUES (
  '$alias',
  '$prijmeni',
  '$jmeno',
  '$varsymbol',
  '$_POST[region]',
  '$_POST[email]',
  '$_POST[kategorie]',
  '$_POST[pidiv]',
  '$_POST[pifak]',
  '$_POST[datreg]',
  '$ip',
  '$_POST[squad]',
  NULLIF('$_POST[Staff]',''),
  '$table'
  )";

  $result = mysql_query($query);
  if (!$result) {
       echo"<BR> <FONT COLOR=RED>Při vkládání do databáze došlo k chybě. Zkuste to později.</FONT><BR>\n";
	     echo mysql_errno($mysql) . ": " . mysql_error($mysql) . "\n";
       die();
  };
}

$result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)) where klic is null or klic=0;");

// Zaslani potvrzeni registrace a platebnich udaju zavodnihovi s odkazy na spravu ucasti (zruseni)
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and VarSym='$varsymbol' and  Mail='$_POST[email]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
  $squad=$nazvy_squadu[$z[Squad]];

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

  $prematch_datum=date('Y-m-d', strtotime("-1 day", strtotime($match_data[Zavod_datum])));
  $DatReg=date('d.m.Y', $z[DatReg]);

  $payLimit=$match_data[Zavod_pocet_dni_na_platbu];

  // Převod datumů na objekty typu DateTime
  $prematchDateTime = new DateTime($prematch_datum);
  $regDateTime = new DateTime($datReg);

  // Odčítání 10 dní od datumu konání prematche
  $prematchDateTime->modify("-$payLimit days");

  if ($regDateTime >= $prematchDateTime) {
      $DatPay=date('d.m.Y', strtotime("-2 day", strtotime($match_data[Zavod_datum])));
  } else {
  	  $DatPay=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", strtotime($DatReg)));
  }

  $tyden=str_replace(' ','',$match_data[Zavod_datum]);
  $tyden=intval(date("W",strtotime($tyden)));
  $varsymbol_new="$tyden".($z[Cislo]);

  $query="update ".$table." set VarSym='$varsymbol_new',DatPay='$DatPay' where VarSym='$varsymbol'";

  $res=mysql_query($query);
  $varsymbol=$varsymbol_new;

  $STRELEC_ALIAS="<b>Alias: $z[Alias]<b>"."\r\n";
  $STRELEC_SHOOTER="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
  $STRELEC_CATEGORY="Kategorie: $z[Kategorie]"."\r\n";
  $STRELEC_DIVISION="Divize: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC_SQUAD="Squad: $squad"."\r\n";
  $STRELEC_RO="Rozhodčí: $Rozhodci"."\r\n";
  $STRELEC_POM="Pomocník: $Pomocnik"."\r\n";
  $STRELEC_VS="Variabilní symbol: $varsymbol"."\r\n";

  $link_cancel="<a href='$web_adresa/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]'><strong>zrušit účast</strong></a>";

echo "
<div class='text-center'>
	<img class='registrovat-bkg' src='./images/EC_ASCII.png'>
</div>
<div class='modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h4 class='modal-title text-success' id='exampleModalLabel'>Úspěšná registrace</h4>
      </div>
      <div class='modal-body'>
		<p class='font-weight-bold mb-1'>Zaregistrovali jsme závodníka s těmito údaji</p>
		<p class='text-monospace ml-3'>
		$STRELEC_ALIAS<br>
		$STRELEC_SHOOTER<br>
		$STRELEC_CATEGORY<br>
		$STRELEC_DIVISION<br>
		$STRELEC_SQUAD<br>
		$STRELEC_RO<br>
		$STRELEC_POM<br>
		<p class='text-primary text-center mb-0'><i class='far fa-info-circle pr-1' style='font-size:16px'></i>Potvrzení registrace s podklady pro platbu startovného byly odeslány na adresu $_POST[email].</p>
		<p class='text-center mb-0 pt-2'>Platbu je nutné provést do $match_data[Zavod_pocet_dni_na_platbu] dnů, jinak bude registrace stornována.</p>
      </div>
      <div class='modal-footer mb-3'>
		<a href='./registrace.php' rel='modal:close'><button type='button' class='btn btn-primary'>Nová registrace</button></a>&nbsp;&nbsp;
		<a href='./kontrola_aliasu_2023.php' rel='modal:close'><button type='button' class='$paymentBeforeClass btn btn-success'>Kontrola aliasů série</button></a>&nbsp;&nbsp;
		<!--a href='./zavodnici.php' rel='modal:close'><button type='button' class='btn btn-default'>Zavřít</button></a-->
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

// priprava podkladu pro email zavodnikovi
  $STRELEC="<b>Alias: $z[Alias]</b>"."\r\n";
  $STRELEC.="Střelec: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="Kategorie: $z[Kategorie]"."\r\n";
  $STRELEC.="Divize: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="Squad: $squad"."\r\n\r\n";
  $STRELEC.="<i>Rozhodčí: $Rozhodci"."\r\n";
  $STRELEC.="Pomocnik: $Pomocnik</i>"."\r\n";

  $DatReg=date('d.m.Y', $z[DatReg]);

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

  $from_text="";
  $from=$match_data[Zavod_email_from];
  $to=$_POST[email];
  $subject = "Registrace ".$match_data[Zavod];

	if (($z[Staff]=="RO") or ($z[Staff]=="POM")) {
		$message=$email_registrace_bez_platby_text;
		$query="UPDATE ".$table." SET Zaplaceno='on' ,Castka='0',Mena='$match_data[Banka_ucet_MENA]',DatumZaplaceni='$dnes' WHERE Cislo='$z[Cislo]' AND klic='$z[klic]'";
		$res=mysql_query($query);
	} elseif ($_POST[squad]=="-2") {
		$message=$email_registrace_cekatel_text;
	} elseif ($match_data[Payment_before]=="") {
 		$message=$email_registrace_zavod_bez_platby_predem;
	} else {
		$message=$email_registrace_platba_text;
	}
  $message=str_replace("##ALIAS##",$STRELEC,$message);
  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

// posilame email zavodnikovi
  email($from_text,$from,$to,$subject, $message);

// zapiseme do DB, ze registracni mail byl odeslan
  $query_odeslano="UPDATE ".$table." SET OdeslanRegMail='1' WHERE Mail='$_POST[email]' AND OdeslanRegMail IS NULL";
  $res3=mysql_query($query_odeslano);
};

?>
