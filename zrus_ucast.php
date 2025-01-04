<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico" />
    <title>KPS Eggenberg - registrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="./styles/style_admin.css">
</HEAD>
<BODY>
<H3 class="nadpis">Vyřazení závodníka</H3>
<?php
require_once ("./config/data.php");
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

$query="select * from $table WHERE Cislo=$compId and klic=$klic";
$result=mysql_query($query);
$z=mysql_fetch_array($result);

//TO-DO
if ((isset($_GET[vyradit])) and ($z[Zaplaceno]=="on")) {
	echo "<strong><FONT COLOR=RED>Startovné s variabilním symbolem $z[VarSym] (závodník $z[Jmeno] $z[Prijmeni] \"$z[Alias]\") je uhrazené, účast v závodu již nelze zrušit.</FONT></strong>
		<li>V souladu s pravidly závodu je však možné přenést jej na jiného závodníka.</li>
		";
	die();
}
//TO-DO

$ip=$_SERVER["REMOTE_ADDR"];
if (isset($_GET[vyradit])) {
  $query="UPDATE ".$table." 
	SET 
		Squad=-9
		,Vyrazeno='$dnes'
		,VyrazenoIP='$ip'
	WHERE 
		Cislo=$compId and klic=$klic";
}
//echo "<pre>$query</pre>";
$result = mysql_query($query);
  if (!$result) {
      echo"<FONT COLOR=RED> Omlouvame se - došlo k chybě pri vkládaní do databáze - zkuste to později</FONT><BR>";
      echo "<pre>".'MySQL Error: ' . mysql_error() ."</pre>";
  } elseif (mysql_affected_rows()==0) {
      echo "<strong><FONT COLOR=RED>Změna jej již v databázi uložená.";
  } else

{
    $query="select * from $table where Cislo=$compId";
    $strelci=mysql_query($query);
    $z=mysql_fetch_array($strelci);

    $squad=$nazvy_squadu[$z[Squad]];
    $STRELEC="ALIAS: $z[Alias]"."\r\n";
    $STRELEC.="STŘELEC: #$z[Cislo] $z[Prijmeni] $z[Jmeno]"."\r\n";
    $STRELEC.="DIVIZE: $z[Pidiv] $z[Pifak]"."\r\n";
    $STRELEC.="SQUAD: $squad"."\r\n";
    $STRELEC.="ZRUŠENO Z IP: $ip"."\r\n";

    if (isset($_GET[vyradit])) {
      echo "<p>Byl(a) jste vyřazen(a) ze závodu <strong>$zavod</strong>. Děkujeme za uvolnění místa případnému dalšímu zájemci :-).</p>";
      $subject = "zrušení registrace závodníka - ".$zavod;
      $message=$email_text_vyrazeni_vlastni;
      $message=str_replace("##STRELEC##", $STRELEC, $message);
      if (email($email_od_text,$email_od,$z[Mail], $subject, $message)) {
        echo "<i>Email s informací o zrušení účasti byl odeslán na adresu zadanou při registraci.</i>";
      }
    }

// pošle informaci o nové registraci na email registrace@kps-eggenberg.cz (milan@g17.cz a antoni.liska@seznam.cz)
$from=$email_od;
$from_text=$email_od_text;
$to=$email_od;
$subject = $zavod." - zrušení účasti";
$message = "Závodník zrušil svoji účast.

##STRELEC##
";

$message=str_replace("##STRELEC##",$STRELEC,$message);
email($from_text,$from,$to, $subject, $message);
};

?>
</body>
</html>