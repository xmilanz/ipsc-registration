<?php
/*
  JUMBO 26.10.2017
  aktualizace tabulek na verzi 2.3  
*/


$result = mysql_query("ALTER TABLE $table_nastaveni ADD `parNote1` varchar(100) DEFAULT NULL;");
if (!$result) {
    die();
}
$result = mysql_query("ALTER TABLE $table_nastaveni ADD `parNote2` varchar(100) DEFAULT NULL;");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.3 where parName='dbver';");
if (!$result) {
    die();
}


?>
