<?php
/*
  MILANZ 11.6.2022
  aktualizace tabulek na verzi 2.9 - presunuti konfigurace zavodu do databaze
*/

$result = mysql_query("INSERT INTO match_config (Zavod_id) VALUE ('$table')");
if (!$result) {
    die();
}

$result = mysql_query("update match_config set Payment_before='on' where Zavod_id='$table'");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.9 where parName='dbver'");
if (!$result) {
    die();
}

?>
