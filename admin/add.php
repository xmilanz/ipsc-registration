<HTML>
<HEAD>
   <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico" />
    <title>KPS Eggenberg - administrace registrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">

</HEAD>
<BODY>

<?php
	include ("./db/dbconn.php");
	$ip=($_SERVER["REMOTE_ADDR"]." - admin");
// kontrola zadanych udaju
  echo "<br><br><br>";

if ($_POST[alias]==""){
  echo "<strong><li>nebyl zadaný ALIAS</strong><br>";
  echo "<button style='margin: 5px 0 10px 20px' onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n<BR>";
  $chyba=1;
};

$alias=mb_convert_case($_POST[alias], MB_CASE_UPPER, "UTF-8");
$check="SELECT * FROM $table WHERE Alias = '$alias'";
$rs = mysql_query($check);
$data = mysql_fetch_array($rs, MYSQLI_NUM);
if($data[0] > 1) {
    echo "<H4><li>závodník s aliasem $alias je již registrovaný!</H4>";
    echo "<button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n";
  $chyba=1;
}

if ($_POST[prijmeni]==""){
  echo "<strong><li>nebylo zadané příjmení</strong><br>";
  echo "<button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n<BR>";
  $chyba=1;
};

if ($_POST[jmeno]==""){
  echo "<strong><li>nebylo zadané jsméno</strong><br></FONT>";
  echo "<button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button><BR>";
  $chyba=1;
};

if ($_POST[email]==""){
  echo "<strong><li>nebyla zadaná emailová adresa</strong><br></FONT>";
  echo "<button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button><BR>";
  $chyba=1;
};

if (!filter_var($_POST[email], FILTER_VALIDATE_EMAIL)) {
  echo "<strong><li>emailová adresa ($_POST[email]) není platná.</strong><br>";
  echo "<button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n";
  $chyba=1;
}

// pokud je vse v poradku
if ($chyba<>"1"){
  include ("auth.php");

  $varsymbol=substr(rand(),0,4);
  $alias=trim(mb_convert_case($_POST[alias], MB_CASE_UPPER, "UTF-8"));
  $prijmeni=trim(mb_convert_case($_POST[prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[prijmeni_stav].'';
  $prijmeni=ucfirst(strtolower($prijmeni));
  $jmeno=trim(mb_convert_case($_POST[jmeno], MB_CASE_TITLE, "UTF-8"));

  $query="INSERT INTO ".$table." (Alias,Prijmeni,Jmeno,VarSym,Region,Mail,Kategorie,Pidiv,Pifak,Squad,DatReg,RegistraceIP,RO,VIP,Poznamka,PotvrzenoOdeslano)
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
  '$_POST[squad]',
  '$_POST[datreg]',
  '$ip',
  '$_POST[RO]',
  '$_POST[VIP]',
  '$_POST[poznamka]',
  '1'
  )";

$result = mysql_query($query);
  if (!$result) {
	echo "<h3 class='nadpis'>..: Nový závodník :..</h3>";
	echo "<center>";
		echo"<FONT COLOR=RED>Při vkládání do databáze došlo k chybě. Zkuste to později.</FONT><BR><BR>\n";
		echo "<span style='font-family:courier;'>MySQL Error: ". mysql_error();"</span>";
	echo "<br><br><button style='margin: 5px 0 10px 20px'  onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět</button>\n";
	echo "</center>";
	die();
}
else {
	header("refresh:0;url=index.php");
};

$result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)) where klic is null or klic=0;");

// Zaslani potvrzeni registrace a platebnich udaju zavodnihovi s odkazy na spravu ucasti (zruseni)
  $query="select * from $table where Prijmeni='$prijmeni' and Jmeno='$jmeno' and VarSym='$varsymbol' and Mail='$_POST[email]';";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
  $squad=$nazvy_squadu[$z[Squad]];

   $tyden=str_replace(' ','margin: 5px 0 10px 20px',$zavod_datum);
  $tyden=intval(date("W",strtotime($tyden)));
  $varsymbol_new="$tyden".($z[Cislo]); //prefix "18" pro var.symbol pistole.  
  $query="update ".$table." set VarSym='$varsymbol_new' where VarSym='$varsymbol'";
  $res=mysql_query($query);
  $varsymbol=$varsymbol_new;

   if ($z[RO]=="on") {
     $Rozhodci="ANO";
   } else {
     $Rozhodci="NE";
   }

  $link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

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

	if (($_POST[VIP]=="on") or ($_POST[RO]=="on")){
	    $message=$email_registrace_bez_platby_text_admin;
	}
	else {
	    $message=$email_registrace_platba_text_admin;
	}
  $message=str_replace("##ALIAS##",$STRELEC,$message);
  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

  email($from_text,$from,$to,$subject, $message);

// zapiseme do DB, ze registracni mail byl odeslan
  $query_odeslano="update ".$table." set PotvrzenoOdeslano='1' where Mail='$_POST[email].' and PotvrzenoOdeslano is null";
  $res3=mysql_query($query_odeslano);

};
?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
</body>
</HTML>