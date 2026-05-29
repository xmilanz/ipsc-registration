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
    "danger",
    "Vyřazení závodníka",
    "index.php",
    [
        "shooterID" => $shooterID,
        "shooterKEY" => $shooterKEY
    ],
    "Opravdu chcete vyřadit závodníka<br>#" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")?",
    "Závodník nebude odstraněn, ale přesunut do squadu VYŘAZENO (-9).",
    "./save.php",
    "shooter_cancel",
    "Vyřadit závodníka",
);