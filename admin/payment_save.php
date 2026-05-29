<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/config/data.php';
require_once __DIR__ . '/db/dbconn.php';
require_admin();

$shooterID = intval($_GET['ID']);
$shooterKEY = intval($_GET['KEY']);

$line = getShooterData($conn, $table, $shooterID, $shooterKEY);

include './components/modal-warning-form.php';
WarningModalForm(
    "success",
    "Evidence úhrady startovného",
    "index.php",
    [
        "shooterID" => $shooterID,
        "shooterKEY" => $shooterKEY
    ],
    "Závodník #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ") zaplatil.",
    "Zaevidujeme platbu a pošleme závodníkovi potvrzení.",
    "./save.php",
    "payment_save",
    "Zaevidovat platbu"
);