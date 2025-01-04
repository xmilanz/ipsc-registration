<?php
/*
  JUMBO 26.10.2017
  aktualizace tabulek na verzi 2.2  
*/


$result = mysql_query("ALTER TABLE $table ADD `klic` int(11) NOT NULL DEFAULT '0';");
if (!$result) {
  echo "KLIC: chyba aktualizace verze databáze ";
}
$result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 900)) where klic is null or klic=0 ;");

$result = mysql_query("ALTER TABLE $table ADD `Potvrzeno` varchar(3) DEFAULT NULL;");
if (!$result) {
  echo "Potvrzeno: chyba aktualizace verze databáze ";
}
$result = mysql_query("ALTER TABLE $table ADD `PotvrzenoIP` varchar(50) DEFAULT NULL;");
if (!$result) {
  echo "PotvrzenoIP: chyba aktualizace verze databáze ";
}
$result = mysql_query("ALTER TABLE $table ADD `PotvrzenoDate` datetime DEFAULT NULL;");
if (!$result) {
  echo "PotvrzenoDate: chyba aktualizace verze databáze ";
}
$result = mysql_query("ALTER TABLE $table ADD `PotvrzenoOdeslano` varchar(3) DEFAULT NULL;");
if (!$result) {
  echo "PotvrzenoOdeslano: chyba aktualizace verze databáze ";
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.2 where parName='dbver';");
if (!$result) {
  echo "chyba uložení verze databáze";
}


?>
