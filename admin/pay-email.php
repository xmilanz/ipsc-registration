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
	require_once ("auth.php");
	require_once ("./db/dbconn.php");
	require_once ("./functions.php");

$id=intval($_GET[id]);
$query="select * from $table where Cislo=$id;";
  $strelec=mysql_query($query);
  $z=mysql_fetch_array($strelec);
  $squad=$nazvy_squadu[$z[Squad]];
  $varsymbol=$z[VarSym];

  $STRELEC_ALIAS="ALIAS: $z[Alias]"."\r\n";
  $STRELEC_SHOOTER="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
  $STRELEC_DIVISION="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC_SQUAD="SQUAD: $squad"."\r\n";
  $STRELEC_VS="Variabilní symbol: $varsymbol"."\r\n";
  
  $link_cancel="<a href='$web_adresa_admin/zrus_ucast.php?id=$z[Cislo]&klic=$z[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

// priprava podkladu pro email zavodnikovi
  $STRELEC="ALIAS: $z[Alias]"."\r\n";
  $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno] [$link_cancel]"."\r\n";
  $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
  $STRELEC.="SQUAD: $squad"."\r\n";

  $DatReg=date('d.m.Y', $z["DatReg"]);
  $DatPay=date('d.m.Y', strtotime("+$zavod_pocet_dni_na_platbu day", $z["DatReg"]));

  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$qr_banka_ucet_cislo&bankCode=$qr_banka_ucet_kod&amount=$banka_ucet_CASTKA&currency=CZK&vs=".$varsymbol."&message=$qr_zprava&size=100";

  $from_text=$email_od_text;
  $from=$email_od;
  $to=$z[Mail];
  $subject = "Chybějící platba ".$zavod;

  $message=$email_urgence_platba_text_admin;
  $message=str_replace("##ALIAS##",$STRELEC,$message);
  $message=str_replace("##STRELEC##",$STRELEC,$message);
  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
  $message=str_replace("##QR_LINK##",$qr_link,$message);
  $message=str_replace("##DatReg##",$DatReg,$message);
  $message=str_replace("##DatPay##",$DatPay,$message);

  email($from_text,$from,$to,$subject, $message);

  $dnes=date_format(new DateTime(),"Y-m-d");
  $query_odeslano="UPDATE ".$table." SET Urgence='$dnes' where Cislo='$id';";
  $res3=mysql_query($query_odeslano);

  echo "<H3 class=\"nadpis\">Urgence registrace</H3>\n";
  echo "<center>Upozornění na nezaplacení bylo odesláno na adresu <b>$to</b><br><br>
		$STRELEC_ALIAS<br>
		$STRELEC_SHOOTER<br>
		$STRELEC_DIVISION<br>
		$STRELEC_SQUAD<br><br>
		$STRELEC_VS<br><br>";
	echo "<br><a href=\"#\" rel=\"modal:close\"><button style=\" padding:3px; cursor:pointer;\">Zavřít okno</button></a></center>";	
?>
</BODY>
</HTML>