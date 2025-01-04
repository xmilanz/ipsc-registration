<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico"/>
    <title>KPS Eggenberg - administrace registrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
</HEAD>
<BODY>

<?php
    require_once ("./auth.php");
    require_once ("./db/dbconn.php");
    require_once ("./functions.php");

$compId=intval($_GET[id]);
$klic=intval($_GET[klic]);

$dnes=date_format(new DateTime(),"d.m.Y H:i");

$query="select * from $table WHERE Cislo=$compId and klic=$klic";
$result=mysql_query($query);
if (!$strelec=mysql_fetch_array($result)) {
  die('<strong><FONT COLOR=RED>Nelze dohledat střelce</FONT></strong>');
}

$mena=$banka_ucet_MENA;
$castka=$banka_ucet_CASTKA;

if (($strelec[VIP]=='on') or ($strelec[RO]=='on')) {
  $mena=$banka_ucet_MENA;
  $castka=0;
  $message=$email_text_potvrzeni_admin;
}

$query="UPDATE $table 
  SET 
    Zaplaceno='on'
    ,Castka='$castka'
    ,Mena='$mena'
    ,DatumZaplaceni='$dnes'
  WHERE 
    Cislo=$compId 
    and klic=$klic";

if (isset($_GET[vyradit])) {
  $query="UPDATE ".$table." SET Squad=-9,Vyrazeno='$dnes' WHERE Cislo=$compId and klic=$klic";
}
$result = mysql_query($query);
  if (!$result) {
       echo"<FONT COLOR=RED> Omlouvame se - chyba pri vkladani do databaze - zkuste to pozdeji </FONT><BR>";
       echo 'MySQL Error: ' . mysql_error();
  } elseif (mysql_affected_rows()==0) {
       echo"<br><center><h3><FONT COLOR=RED> Změna je již v databázi uložená - ignoruji akci</FONT></h3></enter>";
	   echo "<br><a href=\"index.php\" onclick=\"window.location.reload(true);\"><button style=\" padding:3px; cursor:pointer;\">Zavřít</button></a></center>";
  } else {

    $query="select * from $table where Cislo=$compId";
    $strelci=mysql_query($query);
    $z=mysql_fetch_array($strelci);

	$DatReg=date('d.m.Y', $z["DatReg"]);
	$DatPay=date('d.m.Y', strtotime("+$zavod_pocet_dni_na_platbu day", $z["DatReg"]));

    $squad=$nazvy_squadu[$z[Squad]];
	$STRELEC="ALIAS: $z[Alias]"."\r\n";
    $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
    $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
    $STRELEC.="SQUAD: $squad"."\r\n";
    
    if (isset($_GET[vyradit])) {
	  // zavodnik nezaplatil - vyrazeni
      echo "<H3 class=\"nadpis\">Vyřazení závodníka</H3>\n";
      echo "<center><p>Střelec byl vyřazen ze závodu <strong>$zavod</strong><br>(přesunut do squadu -9).</p>";
      $subject = "Zrušení registrace závodníka - ".$zavod;
      $message=$email_text_vyrazeni_admin;
      $message=str_replace("##STRELEC##", $STRELEC, $message);
	  $message=str_replace("##DatReg##",$DatReg,$message);
		if (email($email_od_text,$email_od,$z[Mail], $subject, $message)) {
        echo "<p><i>Email s informací o vyřazení z registrace kvůli nezaplacení<br>byl odeslán závodníkovi.</i></p>";
      }
    } else {
	  // zavodnik zaplatil
			if (($strelec[Squad]==0) or ($strelec[VIP]=='on') or ($strelec[RO]=='on')) {
				      echo "<H3 class=\"nadpis\">Potvrzení účasti</H3>\n";
					  echo "<center><p>Posílám potvrzení účasti RO, VIP a závodníkům v Prematchi<br></p>";
					  $subject = "Potvrzení účasti ".$zavod;
					  $message=$email_text_potvrzeni_admin;      
					  $message=str_replace("##STRELEC##", $STRELEC, $message);
						 if (email($email_od_text,$email_od,$z[Mail], $subject, $message)) {
						 echo "<p><i>Email s potrzením účasti byl odeslán závodníkovi.</i></p>";
						}
			}
			else {
					  echo "<H3 class=\"nadpis\">Potvrzení zaplacení</H3>\n";
					  echo "<center><p>Platba s variabilním symbolem $z[VarSym] byla zaevidovaná (u pomocníků posíláme potvrzení účasti)<br></p>";
					  $subject = "Evidence platby ".$zavod;
					  $message=$email_text_platba;      
					  $message=str_replace("##STRELEC##", $STRELEC, $message);
						 if (email($email_od_text,$email_od,$z[Mail], $subject, $message)) {
						 echo "<p><i>Email s potrzením evidence platby byl odeslán závodníkovi.</i></p>";
						}
			}
    }
	echo "<br><a href=\"index.php\" onclick=\"window.location.reload(true);\"><button style=\" padding:3px; cursor:pointer;\">Zavřít</button></a></center>";
  };
?>
</body>
</html>