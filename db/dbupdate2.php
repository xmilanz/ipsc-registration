<?php
/*
  JUMBO 26.10.2017
  aktualizace tabulek na verzi 2  
*/


$result = mysql_query("update $table_nastaveni set parValueI=2 where parName='dbver';");
if (!$result) {
    die();
}



?>
