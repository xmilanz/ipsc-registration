<?php
/*
  MILANZ 20.7.2023
  aktualizace tabulek na verzi 3.1 
*/

$result = mysql_query("INSERT INTO match_config (Zavod_id) VALUE ('$table');");
if (!$result) {
     die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=3.1 where parName='dbver';");
if (!$result) {
    echo "";
}

?>
