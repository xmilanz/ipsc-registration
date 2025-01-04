<?php
/*
  MILANZ 12.9.2020
  aktualizace tabulek na verzi 2.8
*/


$result = mysql_query("ALTER TABLE $table ADD `Alias` varchar(16) AFTER `Cislo`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `Urgence` VARCHAR(255) DEFAULT NULL AFTER `Poznamka`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `Vyrazeno` VARCHAR(255) DEFAULT NULL AFTER `PotvrzenoOdeslano`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `VIP` varchar(3) DEFAULT NULL  AFTER `RO`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `POM` varchar(3) DEFAULT NULL  AFTER `VIP`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `RegistraceIP` varchar(50) DEFAULT NULL  AFTER `DatReg`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `VyrazenoIP` varchar(50) DEFAULT NULL  AFTER `Vyrazeno`;");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table ADD `OdeslanRegMail` varchar(3) DEFAULT NULL  AFTER `klic`;");
if (!$result) {
    echo "";
}

/* 
  smazeme nepotrebne sloupce
*/

$result = mysql_query("ALTER TABLE $table DROP `Potvrzeno`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `PotvrzenoOdeslano`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `PotvrzenoIP`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `PotvrzenoDate`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `Ulice`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `Mesto`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `Psc`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `InvoiceAddress`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `DatumDodani`");
if (!$result) {
    echo "";
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.8 where parName='dbver'");
if (!$result) {
     echo "";
}
?>
