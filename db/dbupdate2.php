<?php
/*
  MilanZ 
  aktualizace tabulek na verzi 2
*/

//$result = $conn->query("");

/* aktualizace verze databáze */
$result = $conn->query("update $table_nastaveni set parValueI=2 where parName='dbver';");

?>
