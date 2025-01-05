<?php
require_once ("./db/dbconn.php");
require_once ("./functions.php");
$dnes=date_format(new DateTime(),"d.m.Y H:i");

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);

 if ($match_data[Payment_before]=="on"){

// ziskame seznam zavodniku, kteri nezaplatili do "zavod_pocet_dni_na_platbu" (10) dnu od registrace - ty pak vyřadíme
$query="SELECT * FROM $table WHERE DatPay = DATE_FORMAT(CURDATE(), \"%d.%m.%Y\") AND Squad >= '100' AND ZaplatiNaMiste IS NULL  AND Zaplaceno IS NULL";

$result1 = mysql_query($query) or die('Query failed: ' . mysql_error());
if (mysql_num_rows($result)==0) {
	die(); 
}
else {
    while ($res1=mysql_fetch_array($result1)) {
      $alias=$res1[Alias];
      $query2="select * from $table where Alias='$res1[Alias]'";
      $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());

	while ($res2=mysql_fetch_array($result2)){
	    $DatReg=date('d.m.Y', $res2[DatReg]);

	    // priprava podkladu pro email zavodnikovi
	    $STRELEC="Datum registrace: $DatReg"."\r\n";
	    $STRELEC.="Termín platby: $res2[DatPay]"."\r\n\r\n";
	    $STRELEC.="<b>Alias: $res2[Alias]</b>"."\r\n";
	    $STRELEC.="Střelec: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno]"."\r\n";
	    $STRELEC.="Divize: $res2[Pidiv] $res2[Pifak]"."\r\n";
	    $STRELEC.="Squad: $res2[Squad]"."\r\n";

	    $from_text=$email_ffn;
	    $from=$match_data[Zavod_email_from];
	    $to=$res2[Mail];
	    $subject = $match_data[Zavod]." - zrušení účasti";

	    $message=$email_text_vyrazeni_automaticke;
	    $message=str_replace("##ALIAS##",$STRELEC,$message);
	    $message=str_replace("##STRELEC##",$STRELEC,$message);
	    $message=str_replace("##DatReg##",$DatReg,$message);
	    $message=str_replace("##DatPay##",$DatPay,$message);

	    email($from_text,$from,$to,$subject, $message);

	    $query_odeslano="UPDATE ".$table." SET SquadReg='$res2[Squad]',Squad='-9',Vyrazeno='$dnes' WHERE Alias='$res2[Alias]';";
	    $res3=mysql_query($query_odeslano);

	    // pošle pořadateli informaci o vyřazení na email uvedeny v konfiguraci zavodu - match_data[Zavod_email_from]
	    $STRELEC="Datum registrace: $DatReg"."\r\n";
	    $STRELEC.="Termín platby: $res2[DatPay]"."\r\n\r\n";
	    $STRELEC.="<b>Alias: $res2[Alias]</b> "."\r\n";
	    $STRELEC.="Střelec: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno]"."\r\n";
	    $STRELEC.="Původní squad: $res2[Squad]"."\r\n\r\n";
	    $STRELEC.="Email: $res2[Mail]"."\r\n";
	}

	$to=$match_data[Zavod_email_from];
	$message = "Vyřazení závodníka pro nezaplacení.

	##STRELEC##
	";
	$subject = $match_data[Zavod]." - zrušení účasti";
	$message=str_replace("##STRELEC##",$STRELEC,$message);
	$message=str_replace("##DatReg##",$DatReg,$message);
	$message=str_replace("##DatPay##",$DatPay,$message);

	email($from_text,$from,$to, $subject, $message);
    }
  }
 }

else {
	die();
}

?>
