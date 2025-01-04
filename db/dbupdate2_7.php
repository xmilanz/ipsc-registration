<?php
/*
  JUMBO 17.12.2018
  aktualizace tabulek na verzi 2.7  
*/


$result = mysql_query("ALTER TABLE $table ADD `ZaplatiNaMiste` varchar(3) DEFAULT NULL AFTER Zaplaceno;");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.7 where parName='dbver';");
if (!$result) {
    die();
}


?>
