<?php
/*
  JUMBO 17.12.2018
  aktualizace tabulek na verzi 2.4  
*/


$result = mysql_query("ALTER TABLE $table ADD `Castka` FLOAT(9,2) NOT NULL DEFAULT '0';");
if (!$result) {
    die();
}

$result = mysql_query("ALTER TABLE $table ADD `Mena` VARCHAR(3) NOT NULL DEFAULT '$banka_ucet_MENA';");
if (!$result) {
    die();
}

$result = mysql_query("ALTER TABLE $table ADD `DatumZaplaceni` VARCHAR(255) NOT NULL DEFAULT '' AFTER Zaplaceno;");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.5 where parName='dbver';");
if (!$result) {
    die();
}


?>
