<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
if (file_exists('./db/dbconn.php')) {
    include './db/dbconn.php';
} elseif (file_exists('../db/dbconn.php')) {
    include '../db/dbconn.php';
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="praktiscore_shooters.csv"');
header('Pragma: no-cache');
header('Expires: 0');

$query = "select Alias,Cislo,Jmeno,Prijmeni,Mail,Squad,Divize,Faktor,Kategorie,Zaplaceno,Region from $table where Squad >= 0 ORDER BY Cislo;";
$strelci = mysql_query($query);
$csvData = "IPSC#,Shooter#,First Name,Last Name,Email,Squad,Division,PF,Class,Categories,Checkins,Team,Country\r\n";

while ($z = mysql_fetch_array($strelci)) {
	switch ($z['Divize']) {
		case "PRD": $z['Divize'] = "Production"; break;
		case "PDO": $z['Divize'] = "Production Optics"; break;
		case "STD": $z['Divize'] = "Standard"; break;
		case "CLA": $z['Divize'] = "Classic"; break;
		case "REV": $z['Divize'] = "Revolver"; break;
		case "REV6": $z['Divize'] = "Revolver"; break;
		case "OPN": $z['Divize'] = "Open"; break;
		case "PCC": $z['Divize'] = "PCC"; break;
		case "PCCI": $z['Divize'] = "PCC Iron"; break;
		case "PCCO": $z['Divize'] = "PCC Optics"; break;
		case "MR": $z['Divize'] = "Mini Rifle"; break;
		case "MRO": $z['Divize'] = "Mini Rifle Open"; break;
		case "MRS": $z['Divize'] = "Mini Rifle Standard"; break;
		default: $z['Divize'] = "Production"; break;
	}
	switch (true) {
		case ($z['Zaplaceno'] == 'on' && $z['Staff'] == 'RO'): $z['Zaplaceno'] = "RO"; break;
		case ($z['Zaplaceno'] == 'on' && $z['Staff'] == 'POM'): $z['Zaplaceno'] = "Staff"; break;
		case ($z['Zaplaceno'] == 'on'): $z['Zaplaceno'] = "Paid"; break;
		default: $z['Zaplaceno'] = ""; break;
	}
 $csvData .= "{$z['Alias']},{$z['Cislo']},{$z['Jmeno']},{$z['Prijmeni']},{$z['Mail']},{$z['Squad']},{$z['Divize']},{$z['Faktor']},,{$z['Kategorie']},{$z['Zaplaceno']},,{$z['Region']}\r\n";
}

echo iconv("UTF-8", "UTF-8", $csvData);
?>