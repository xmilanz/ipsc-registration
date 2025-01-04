<?php
/*
  JUMBO 17.12.2018
  aktualizace tabulek na verzi 2.4  
*/


$result = mysql_query("ALTER TABLE $table ADD `serie` varchar(1) DEFAULT NULL;");
if (!$result) {
  echo "serie: chyba aktualizace verze databáze ";
}

$result = mysql_query("ALTER TABLE $table_nastaveni DROP INDEX `parName`, ADD INDEX `parName` (`parName`) USING BTREE;");
if (!$result) {
  echo "parName-INDEX: chyba aktualizace verze databáze ";
}


/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.4 where parName='dbver';");
if (!$result) {
  echo "chyba uložení verze databáze";
}


?>
