<?php
/*
   MilanZ
 */
$result = $conn->query("ALTER TABLE $table 
                                   ADD COLUMN `Rocnik` tinyint(4) DEFAULT NULL AFTER `Jmeno`,
                                   ADD COLUMN `ZodpovednaOsoba` varchar(155) DEFAULT NULL AFTER `Rocnik`,
                                   ADD COLUMN `Trenink` tinyint(1) DEFAULT 0 AFTER `ZodpovednaOsoba`,
                                   ADD COLUMN `Klub` varchar(255) DEFAULT NULL AFTER `Region`;
                                   ");

/* aktualizace verze databaze */
$result = $conn->query("
    UPDATE $table_setting
    SET parValue='2.6'
    WHERE parName='dbver'
");

if (!$result) {
    die("MySQL error: " . $conn->error);
}
?>
