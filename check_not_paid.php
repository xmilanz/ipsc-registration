<?php
require_once ("./db/dbconn.php");
require_once ("./functions.php");

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);


// 10.8.2022 - protoze se pri registraci RO, POM a VIP rovnou oznaci jako Zaplaceno=on, zrusena podminka " and (RO!='on' or POM!='on' or VIP!='on') "
//$query="SELECT * FROM $table WHERE DATE_FORMAT(FROM_UNIXTIME(DatReg), \"%Y-%m-%d\") = DATE_ADD(CURDATE(),INTERVAL -$match_data[Zavod_pocet_dni_na_platbu] DAY) AND Squad >= '0' AND (RO!='on' OR VIP!='on' OR POM!='on' OR ZaplatiNaMiste!='on') and Zaplaceno IS NULL AND Urgence IS NULL";


// ziskame seznam zavodniku, kteri nezaplatili do "zavod_pocet_dni_na_platbu" (10) dnu od registrace
$query="SELECT * FROM $table WHERE DATE_FORMAT(FROM_UNIXTIME(DatReg), \"%Y-%m-%d\") = DATE_ADD(CURDATE(),INTERVAL -$match_data[Zavod_pocet_dni_na_platbu] DAY) AND Squad >= '0' AND ZaplatiNaMiste IS NULL AND Zaplaceno IS NULL AND Urgence IS NULL";



// echo "$query";

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
		  $squad=$nazvy_squadu[$res2[Squad]];
		  $varsymbol=$res2[VarSym];
		  $link_cancel="<a href='$web_adresa/zrus_ucast.php?id=$res2[Cislo]&klic=$res2[klic]&vyradit=ano'><strong>zrušit účast</strong></a>";

		// priprava podkladu pro email zavodnikovi
		  $STRELEC="ALIAS: $res2[Alias]"."\r\n";
		  $STRELEC.="STŘELEC: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno] [$link_cancel]"."\r\n";
		  $STRELEC.="DIVIZE: $res2[Pidiv] $res2[Pifak]"."\r\n";
		  $STRELEC.="SQUAD: $squad"."\r\n";

		  $DatReg=date('d.m.Y', $res2["DatReg"]);
		  $DatPay=date('Y-m-d', strtotime("+$match_data[Zavod_pocet_dni_na_platbu] day", $res2["DatReg"]));

		  $qr_link="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=$match_data[Banka_ucet_cislo]&bankCode=$match_data[Banka_ucet_kod]&amount=$match_data[Banka_ucet_CASTKA]&currency=$match_data[Banka_ucet_MENA]&vs=".$varsymbol."&message=$match_data[Zavod]&size=100";

		  $from_text="";
		  $from=$match_data[Zavod_email_from];
		  $to=$res2[Mail];
		  $subject = "Chybějící platba ".$match_data[Zavod];

		  $message=$email_urgence_platba_text;
		  $message=str_replace("##ALIAS##",$STRELEC,$message);
		  $message=str_replace("##STRELEC##",$STRELEC,$message);
		  $message=str_replace("##VAR_SYMBOL##",$varsymbol,$message);
		  $message=str_replace("##QR_LINK##",$qr_link,$message);
		  $message=str_replace("##DatReg##",$DatReg,$message);
		  $message=str_replace("##DatPay##",$DatPay,$message);

		  email($from_text,$from,$to,$subject, $message);

		  $dnes=date_format(new DateTime(),"Y-m-d");
		  $query_odeslano="UPDATE ".$table." SET Urgence='$dnes' where Cislo='$res2[Cislo]';";
		  $res3=mysql_query($query_odeslano);
		}
	}
}
?>