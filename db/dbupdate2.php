<?php
/*
  MilanZ 
  2025-09-13 - aktualizace tabulek na verzi 2 - implementace rolí do administrace
*/

$result = $conn->query("ALTER TABLE site_admins ADD COLUMN role VARCHAR(20) DEFAULT 'editor'");

/* aktualizace verze databáze */
$result = $conn->query("update $table_nastaveni set parValueI=2 where parName='dbver';");

?>
