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
echo "$query";

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
echo "<br><br>Datum registrace: $DatReg"."\r\n";
echo "Termín platby: $res2[DatPay]"."\r\n\r\n";
echo "<b>Alias: $res2[Alias]</b>"."\r\n";
echo "Střelec: #$res2[Cislo] $res2[Prijmeni] $res2[Jmeno]"."\r\n";
echo "Divize: $res2[Pidiv] $res2[Pifak]"."\r\n";
echo "Squad: $res2[Squad]"."\r\n";
	}

  }
 }

}

else {
	
	echo "Payment_before je empty";
//die();
}

?>
