<?php
/*
  MilanZ 
  v registraci je v menu možné skrýt přehledy a závodníky
*/
$check = $conn->query("
    SELECT 1
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '$table_matches'
    AND COLUMN_NAME = 'Web_zobrazovat_prehledy'
");
if ($check->num_rows == 0) {
    $result = $conn->query("
        ALTER TABLE `$table_matches`
        ADD COLUMN `Web_zobrazovat_prehledy` TINYINT(1) DEFAULT 0
        AFTER `Web_zobrazovat_aliasy`
    ");
    if (!$result) {
        die(" 2.7: " . $conn->error);
    }
}

$check = $conn->query("
    SELECT 1
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '$table_matches'
    AND COLUMN_NAME = 'Web_zobrazovat_zavodniky'
");
if ($check->num_rows == 0) {
    $result = $conn->query("
        ALTER TABLE `$table_matches`
        ADD COLUMN `Web_zobrazovat_zavodniky` TINYINT(1) DEFAULT 0
        AFTER `Web_zobrazovat_prehledy`
    ");
    if (!$result) {
        die(" 2.7: " . $conn->error);
    }
}

/* aktualizace verze databaze */
$result = $conn->query("
    UPDATE $table_setting
    SET parValue='2.7'
    WHERE parName='dbver'
");

if (!$result) {
    die("MySQL error 2.7: " . $conn->error);
}
?>