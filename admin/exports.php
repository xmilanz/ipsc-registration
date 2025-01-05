<?php
require_once("db/dbconn.php");


header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="praktiscore_shooters.csv"');
header('Pragma: no-cache');
header('Expires: 0');

$query = "select * from $table where Squad >= 0 ORDER BY Cislo;";
$strelci = mysql_query($query);
$csvData = "IPSC#,Shooter#,First Name,Last Name,Email,Squad,Division,PF,Class,Categories,Checkins,Team,Country\r\n";

while ($z = mysql_fetch_array($strelci)) {
	switch ($z['Pidiv']) {
		case "PRD": $z['Pidiv'] = "Production"; break;
		case "PDO": $z['Pidiv'] = "Production Optics"; break;
		case "STD": $z['Pidiv'] = "Standard"; break;
		case "CLA": $z['Pidiv'] = "Classic"; break;
		case "REV": $z['Pidiv'] = "Revolver"; break;
		case "RE6": $z['Pidiv'] = "Revolver"; break;
		case "OPN": $z['Pidiv'] = "Open"; break;
		case "PCC": $z['Pidiv'] = "PCC"; break;
		case "PCCI": $z['Pidiv'] = "PCC Iron"; break;
		case "PCCO": $z['Pidiv'] = "PCC Optics"; break;
		case "MR": $z['Pidiv'] = "Mini Rifle"; break;
		case "MRO": $z['Pidiv'] = "Mini Rifle Open"; break;
		case "MRS": $z['Pidiv'] = "Mini Rifle Standard"; break;
		default: $z['Pidiv'] = "Production"; break;
	}
	switch (true) {
		case ($z['Zaplaceno'] == 'on' && $z['Staff'] == 'RO'): $z['Zaplaceno'] = "RO"; break;
		case ($z['Zaplaceno'] == 'on' && $z['Staff'] == 'POM'): $z['Zaplaceno'] = "Staff"; break;
		case ($z['Zaplaceno'] == 'on'): $z['Zaplaceno'] = "Paid"; break;
		default: $z['Zaplaceno'] = ""; break;
	}
 $csvData .= "{$z['Alias']},{$z['Cislo']},{$z['Jmeno']},{$z['Prijmeni']},{$z['Mail']},{$z['Squad']},{$z['Pidiv']},{$z['Pifak']},,{$z['Kategorie']},{$z['Zaplaceno']},,{$z['Region']}\r\n";
}

echo iconv("UTF-8", "UTF-8", $csvData);
?>