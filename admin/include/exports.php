<?php

$export=$_GET["export"];
if ($export=="1") {
  $export=true;
} else {
  $export=false;
}

if ($export) {
  if (!file_exists('./export')) {
    mkdir('./export', 0777, true);
  }
    $query="select * from $table where Squad>=0 ORDER BY Cislo;";

// vybereme zavodniky, kteri zaplatili, plati na miste, rozhodci a pomocniky
//    $query="select * from $table where Squad>=100 AND (Zaplaceno='on' OR ZaplatiNaMiste='on' OR Staff='RO' OR Staff=POM'' OR Staff='VIP') ORDER BY Cislo;";

$strelci=mysql_query($query);
while ($z=mysql_fetch_array($strelci)) {

	switch ($z[Pidiv]) {
      case "OPN":
	$z[Pidiv]="Open";
      break;
      case "STD":
	$z[Pidiv]="Standard";
      break;
      case "PRD":
	$z[Pidiv]="Production";
      break;
      case "PDO":
	$z[Pidiv]="Production Optics";
      break;
      case "REV":
	$z[Pidiv]="Revolver";
      break;
      case "RE6":
	$z[Pidiv]="Revolver";
      break;
      case "CLA":
	$z[Pidiv]="Classic";
      break;
      case "PCC":
	$z[Pidiv]="PCC";
      break;
      DEFAULT:
        $z[Pidiv]="Production";
      break;
	}

	switch ($z[Kategorie]) {
      case "REGULAR":
	$z[Kategorie]="";
      break;
      case "Regular":
	$z[Kategorie]="";
      break;
      case "SSENIOR":
	$z[Kategorie]="SUPERSENIOR";
      break;
      case "GSENIOR":
	$z[Kategorie]="Grand Senior";
      break;
	}

	switch(true)
    {
      case ($z[Zaplaceno] == 'on' and $z[Staff] == 'RO'):
		$z[Zaplaceno]="RO";
        break;
      case ($z[Zaplaceno] == 'on' and $z[Staff] == 'POM'):
		$z[Zaplaceno]="Staff";
        break;
      case ($z[Zaplaceno] == 'on' and $z[Staff] == ''):
        $z[Zaplaceno]="Paid";
        break;
      case ($z[Zaplaceno] == 'on' and $z[Staff] == ''):
        $z[Zaplaceno]="Paid";
        break;
      default:
        $z[Zaplaceno]="";
        break;
	}

$csvData.="$z[Alias],$z[Cislo],$z[Jmeno],$z[Prijmeni],$z[Mail],$z[Squad],$z[Pidiv],$z[Pifak],,$z[Kategorie],$z[Zaplaceno],,$z[Region]"."\r\n";

}
  $fh = fopen('./export/praktiscore_shooters.csv', 'w');
  $exportData="IPSC#,Shooter#,First Name,Last Name,Email,Squad,Division,PF,Class,Categories,Checkins,Team,Country"."\r\n";
  $exportData.=iconv("UTF-8", "UTF-8", $csvData);
  fwrite($fh, $exportData);
  fclose($fh);
}
?>
