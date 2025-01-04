<?php
require_once ("./db/dbconn.php");
require_once ("./functions.php");
$dnes=date_format(new DateTime(),"d.m.Y H:i");

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);


// 10.8.2022 - protoze se pri registraci RO, POM a VIP rovnou oznaci jako Zaplaceno=on, zrusena podminka " and (RO!='on' or POM!='on' or VIP!='on') "
//$query="SELECT * FROM $table WHERE DATE_FORMAT(FROM_UNIXTIME(DatReg), \"%Y-%m-%d\") = DATE_ADD(CURDATE(),INTERVAL -$match_data[Zavod_pocet_dni_do_vyrazeni] DAY)  AND Squad >= '0' AND (RO!='on' OR VIP!='on' OR POM!='on' OR ZaplatiNaMiste!='on') AND Zaplaceno IS NULL AND Urgence IS NOT NULL";

// ziskame seznam zavodniku, kteri nezaplatili 3 dny po zaslání urgence (12 dní od registrace - konrola probíká 13. den 1:00)
$query="SELECT * FROM $table WHERE DATE_FORMAT(FROM_UNIXTIME(DatReg), \"%Y-%m-%d\") = DATE_ADD(CURDATE(),INTERVAL -$match_data[Zavod_pocet_dni_do_vyrazeni] DAY)  AND Squad >= '0' AND ZaplatiNaMiste IS NULL AND Zaplaceno IS NULL AND Urgence IS NOT NULL";

//echo "$query";

$result1 = mysql_query($query) or die('Query failed: ' . mysql_error());
if (mysql_num_rows($result)==0) {
	die(); 
}
else {
	while ($res1=mysql_fetch_array($result1)) {
	  $alias=$res1[Alias];
	  $query2="SELECT Cislo,Alias,Prijmeni,Jmeno,PiDiv,Pifak,Squad,Mail,Squad,Klic,DatReg FROM $table WHERE Alias='$res1[Alias]'";
	  $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());

		while ($res2=mysql_fetch_array($result2)){

		// priprava podkladu pro email zavodnikovi
		  $STRELEC="ALIAS: $res2[Alias]"."\r\n";
		  $STRELEC.="STŘELEC: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno]"."\r\n";
		  $STRELEC.="DIVIZE: $res2[Pidiv] $res2[Pifak]"."\r\n";
		  $STRELEC.="SQUAD: $res2[Squad]"."\r\n";

		  $DatReg=date('d.m.Y', $res2["DatReg"]);
		  $DatPay=date('Y-m-d', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", $res2["DatReg"]));
		  $DatUrgence=date('d.m.Y', strtotime("+$match_data[Zavod_pocet_dni_do_vyrazeni] day", $res2["DatReg"]));

		  $from_text="";
		  $from=$match_data[Zavod_email_from];
		  $to=$res2[Mail];
		  $subject = $match_data[Zavod]." - zrušení účasti";

		  $message=$email_text_vyrazeni_automaticke;
		  $message=str_replace("##ALIAS##",$STRELEC,$message);
		  $message=str_replace("##STRELEC##",$STRELEC,$message);
		  $message=str_replace("##DatReg##",$DatReg,$message);
		  $message=str_replace("##DatUrgence##",$DatUrgence,$message);

		  email($from_text,$from,$to,$subject, $message);

		  $query_odeslano="UPDATE ".$table." SET Squad=-9,Vyrazeno='$dnes' WHERE Cislo='$res2[Cislo]' and klic='$res2[Klic]';";

		  $res3=mysql_query($query_odeslano);

		// pošle informaci o vyřazení na email registrace@kps-eggenberg.cz (milan@g17.cz a antoni.liska@seznam.cz)
		  $STRELEC="ALIAS: $res2[Alias] "."\r\n";
		  $STRELEC.="STŘELEC: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno]"."\r\n";
		  $STRELEC.="\r\n"."EMAIL: $res2[Mail]"."\r\n";
		  }  

	$to=$email_from;
	$message = "Závodník byl automaticky vyřazen pro nezaplacení (po urgenci platby 2 dny po termínu zaplacení).

	##STRELEC##
	";
	$subject = $match_data[Zavod]." - zrušení účasti";
	$message=str_replace("##STRELEC##",$STRELEC,$message);

	email($from_text,$from,$to, $subject, $message);
	}
}
?>