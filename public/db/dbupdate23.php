<?php
/*
  MilanZ 
  evidence obcanskeho prukazu - drzitel zbrojniho opravneni
*/

$check = $conn->query("
    SELECT 1
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '$table'
    AND COLUMN_NAME = 'ZbrojniOpravneni'
");

if ($check->num_rows == 0) {

    $result = $conn->query("
        ALTER TABLE `$table`
        ADD COLUMN `ZbrojniOpravneni` TINYINT(1) DEFAULT NULL
        AFTER `ObcanskyPrukaz`
    ");

    if (!$result) {
        die("MySQL error: " . $conn->error);
    }
}
/* aktualizace verze databaze */
$result = $conn->query("
    UPDATE $table_setting
    SET parValue='2.3'
    WHERE parName='dbver'
");

if (!$result) {
    die("MySQL error: " . $conn->error);
}
?>
