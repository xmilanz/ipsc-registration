<?php
/*
  MILANZ 20.12.2034
  aktualizace tabulek na verzi 3.2
*/

$result = mysql_query("ALTER TABLE match_config ADD `Zavod_more_divisions` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci AFTER `Zavod_registrace_pozastaveno`;");
if (!$result) {
    die();
}

$result = mysql_query("ALTER TABLE match_config ADD `Zavod_zbrojni_prukaz` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci AFTER `Zavod_more_divisions`;");
if (!$result) {
    die();
}

$result = mysql_query("ALTER TABLE match_config ADD `Zavod_zobrazovat_sponzory` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci AFTER `Zavod_zbrojni_prukaz`;");
if (!$result) {
    die();
}

$result = mysql_query("ALTER TABLE match_config ADD `Web_zobrazovat_situace` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'on' AFTER `Zavod_zobrazovat_sponzory`;");
if (!$result) {
    die();
}

/* aktualizace verze databáze */
$result = mysql_query("update $table_nastaveni set parValueI=3.2 where parName='dbver';");
if (!$result) {
    echo "";
}

?>
