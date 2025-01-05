<?php
/*
  MILANZ 20.7.2023
  aktualizace tabulek na verzi 3.1 - slouceni Staff (VIP, RO, POM) do jedineho sloupce, evidence pubodniho squadu pri vyrazen
*/

$result = mysql_query("ALTER TABLE $table ADD `SquadReg` varchar(11) AFTER `Squad`;");
if (!$result) {
     echo "no result for SquadReg";
}

$result = mysql_query("ALTER TABLE $table ADD `Staff` varchar(3) AFTER `Pifak` ;");
if (!$result) {
     echo "no result for Staff";
}


/* 
  smazeme nepotrebne sloupce
*/

$result = mysql_query("ALTER TABLE $table DROP `POM`");
if (!$result) {
    echo "";
}

$result = mysql_query("ALTER TABLE $table DROP `RO`;");
if (!$result) {
    echo "";
}


$result = mysql_query("ALTER TABLE $table DROP `VIP`;");
if (!$result) {
    echo "";
}


/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=3.1 where parName='dbver';");
if (!$result) {
    echo "";
}

?>
