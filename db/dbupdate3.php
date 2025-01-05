<?php
/*
  MilanZ 20.7.2023
  aktualizace tabulek na verzi 3
*/


$result = mysql_query("update $table_nastaveni set parValueI=3 where parName='dbver';");
if (!$result) {
    die();
}



?>
