<?php
/*
  JUMBO 17.12.2018
  aktualizace tabulek na verzi 2.4  
*/


$result = mysql_query("ALTER TABLE $table ADD `RO` varchar(3);");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.6 where parName='dbver';");
if (!$result) {
    die();
}


?>
