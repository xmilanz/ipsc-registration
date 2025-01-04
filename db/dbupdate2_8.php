<?php
/*
  MILANZ 12.9.2020
  aktualizace tabulek na verzi 2.8
*/


$result = mysql_query("ALTER TABLE $table ADD `Alias` varchar(16) AFTER `Cislo`;");
if (!$result) {
  echo "Alias: chyba aktualizace verze databáze ";
}

$result = mysql_query("ALTER TABLE $table ADD `Urgence` VARCHAR(255) DEFAULT NULL AFTER `Poznamka`;");
if (!$result) {
  echo "Urgence: chyba aktualizace verze databáze ";
}

$result = mysql_query("ALTER TABLE $table ADD `Vyrazeno` VARCHAR(255) DEFAULT NULL AFTER `PotvrzenoOdeslano`;");
if (!$result) {
  echo "Vyrazeno: chyba aktualizace verze databáze ";
}

$result = mysql_query("ALTER TABLE $table ADD `VIP` varchar(3) DEFAULT NULL  AFTER `RO`;");
if (!$result) {
  echo "VIP: chyba aktualizace verze databáze ";
}


$result = mysql_query("ALTER TABLE $table ADD `RegistraceIP` varchar(50) DEFAULT NULL  AFTER `DatReg`;");
if (!$result) {
  echo "DatReg: chyba aktualizace verze databáze ";
}

$result = mysql_query("ALTER TABLE $table ADD `VyrazenoIP` varchar(50) DEFAULT NULL  AFTER `Vyrazeno`;");
if (!$result) {
  echo "Vyrazeno: chyba aktualizace verze databáze ";
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.8 where parName='dbver';");
if (!$result) {
  echo "chyba uložení verze databáze";
}


?>
