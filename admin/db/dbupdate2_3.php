<?php
/*
  JUMBO 26.10.2017
  aktualizace tabulek na verzi 2.3  
*/


$result = mysql_query("ALTER TABLE $table_nastaveni ADD `parNote1` varchar(100) DEFAULT NULL;");
if (!$result) {
  echo "parNote1: chyba aktualizace verze databáze ";
}
$result = mysql_query("ALTER TABLE $table_nastaveni ADD `parNote2` varchar(100) DEFAULT NULL;");
if (!$result) {
  echo "parNote2: chyba aktualizace verze databáze ";
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.3 where parName='dbver';");
if (!$result) {
  echo "chyba uložení verze databáze";
}


?>
