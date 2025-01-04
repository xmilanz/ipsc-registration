<?php
include "./db/dbconn.php";
include "./header.php";

#odkomentovat v případě uzavřené registrace do prematche
#if ($_POST[squad]=="0"){
#  echo "<H3>Registrace do prematche je uzavřená.</h3>";
#  echo "<i>Máte-li zájem pomáhat při závodu, zkontaktujte pořadatele.</i><BR><BR>";
#  echo "<button onclick=\"window.location.href = 'registrace.php';\">Zpět</button>\n";
#  $chyba=1;
#}
#;

# pokud je vse v poradku;

/* zkontrolovat max pocet ve squadu */
$squad_max=$squad_main_max;
if ($_POST[squad]==0) {
  $squad_max=$squad_prem_max;
}
$query = "SELECT Count(Prijmeni) FROM ".$table." WHERE Squad=\"".$_POST[squad]."\"";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$line = mysql_fetch_row($result);
$squad_pocet=$line[0];
if ($squad_pocet>=$squad_max) {
  $chyba=1;
  echo "<H3>Squad $_POST[squad] je již naplněný.</H3>";
  echo "<button  onclick=\"window.location.href = 'registrace.php';\">Vyberte jiný squad</A><BR>";
}

if ($chyba<>"1") {
  $varsymbol=substr(rand(),0,4);
  $alias=trim(mb_convert_case($_POST[alias], MB_CASE_UPPER, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[prijmeni_stav].'';
  $prijmeni = ucfirst(strtolower($prijmeni));
  $jmeno=trim(mb_convert_case($_POST[jmeno], MB_CASE_TITLE, "UTF-8"));

$ip=$_SERVER["REMOTE_ADDR"];

//kontrola, zda je závodnik s aliasem nebo jmenem a primenim uz zaregistrovan
$check="SELECT * FROM $table WHERE ((Alias = '$alias') OR (Jmeno = '$jmeno' AND Prijmeni = '$prijmeni')) AND Squad>=-2";
$check_z=mysql_query($check);
$zavodnik=mysql_fetch_array($check_z);

if ($prijmeni==$zavodnik[Prijmeni] AND $jmeno==$zavodnik[Jmeno]){
  echo "<H3>Závodník $jmeno $prijmeni už je zaregistrovaný</H3>";
//    echo "<i>Zkontrolujte zaregistrované závodníky</i><BR>";
    echo "<i>Buď vás už někdo zaregistroval nebo máte stejné jméno a příjmení jako jiný závodník :-) V tom případě napište pro odlišení za Vaše příjmení $prijmeni nějaký další znak (např. <b>$prijmeni"."1)"."</b></i><BR>";
    echo "<i>Kombinaci Jméno Příjmení byste měli používat v průběhu celé série závodu.</i><BR><BR>";
    echo "<i>Po kliknutí na tlačítko Zpět se vrátíte na registrační stránku - údaje zadané do formuláře v příslušném squadu budou stále vyplněné - opravte je.</i><BR><BR>";
//	echo "<button onclick=\"window.location.href = 'registrace.php';\">Zpět</button>\n";
	echo "<button class='btn btn-primary waves-effect waves-light onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n";
	die();
}
if ($alias==$zavodnik[Alias]){
  echo "<H3>Závodník s aliasem $alias už je zaregistrovaný</H3>";
    echo "<i>V případě, že jste zadali skutečně váš zaregistrovaný alias, zkontaktujte pořadatele.</i><BR>";
    echo "<i>Pokud používáte alias nezaregistrovaný na IPSC-TECH.ORG, použijte tento <a href='https://www.ipsc-tech.org/ics/hq/embdAliasReg.aspx' target='_new'>odkaz</a> a zaregistrujte se.</i><BR>";
	echo "<i>Kombinaci Jméno Příjmení byste měli používat v průběhu celé série závodu.</i><BR><BR>";
	echo "<i>Po kliknutí na tlačítko Zpět se vrátíte na registrační stránku - údaje zadané do formuláře v příslušném squadu budou stále vyplněné - opravte je.</i><BR><BR>";
//	echo "<button onclick=\"window.location.href = 'registrace.php';\">Zpět</button>\n";
	echo "<button class='btn btn-primary waves-effect waves-light' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n";
	die();
}

else
{
  $query="INSERT INTO ".$table." (Alias,Prijmeni,Jmeno,VarSym,Region,Mail,Kategorie,Pidiv,Pifak,DatReg,RegistraceIP,Squad,RO,PotvrzenoOdeslano) 
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
  '$_POST[RO]',
  '1'
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

   if ($z[RO]=="on") {
     $Rozhodci="ANO";
   } else {
     $Rozhodci="NE";
   }

  $tyden=str_replace(' ','',$zavod_datum);
  $tyden=intval(date("W",strtotime($tyden)));
  $varsymbol_new="$tyden".($z[Cislo]); //prefix "18" pro var.symbol pistole.  
  $query="update ".$table." set VarSym='$varsymbol_new' where VarSym='$varsymbol'";
  $res=mysql_query($query);
  $varsymbol=$varsymbol_new;

  $STRELEC_ALIAS="ALIAS: $z[Alias]"."\r\n";
  $STRELEC_SHOOTER="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
  $STRELEC_DIVISION="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC_SQUAD="SQUAD: $squad"."\r\n";
  $STRELEC_VS="Variabilní symbol: $varsymbol"."\r\n";
  
  $link_cancel="<a href='$web_adresa/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

//po dobu 5s zobrazime informace na strance registracniho formulare
  echo "<br><H3>Vaše registrace byla úspěšně dokončená</H3>\n";
  echo " $STRELEC_ALIAS<br>
		$STRELEC_SHOOTER<br>
		$STRELEC_DIVISION<br>
		$STRELEC_SQUAD<br>
		$STRELEC_VS<br><br>
		<b><i>Potvrzení registrace bylo odeslané na email $_POST[email] zadaný při registraci</b></i><br>
		<p class='text-danger font-weight-bold mt-2'>Tip! V menu 'Kontrola aliasů série' můžete ověřit, zda jste v registraci předchozích kol nezadali jiný alias.</p>";
		
// priprava podkladu pro email zavodnikovi
  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="SQUAD: $squad"."\r\n";
  $STRELEC.="ROZHODČÍ: $Rozhodci"."\r\n";

  $DatReg=date('d.m.Y', $z["DatReg"]);
  $DatPay=date('d.m.Y', strtotime("+$zavod_pocet_dni_na_platbu day", $z["DatReg"]));

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$qr_banka_ucet_cislo&bankCode=$qr_banka_ucet_kod&amount=$banka_ucet_CASTKA&currency=CZK&vs=".$varsymbol."&message=$qr_zprava&size=100";

  $from_text=$email_od_text;
  $from=$email_od;
  $to=$_POST[email];
  $subject = "Registrace ".$zavod;

  	if (($z[RO]=="on") or ($_POST[squad]=="0")) {
		$message=$email_registrace_bez_platby_text;
	}
  	elseif ($_POST[squad]=="-2") {
		$message=$email_registrace_cekatel_text;
	}
	else {
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
  $query_odeslano="update ".$table." set PotvrzenoOdeslano='1' where Mail='$_POST[email].' and PotvrzenoOdeslano is null";
  $res3=mysql_query($query_odeslano);
};

header("refresh:5;url=registrace.php");

include "./footer.php"
?>