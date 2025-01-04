<?php
/*
  JUMBO 26.10.2017
  aktualizace tabulek na verzi 2.1  
*/


$result = mysql_query("ALTER TABLE $table CHANGE `VarSym` `VarSym` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `DatReg`;");
if (!$result) {
  echo "chyba aktualizace verze databáze";
}


/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=2.1 where parName='dbver';");
if (!$result) {
  echo "chyba aktualizace verze databáze";
}
?>
