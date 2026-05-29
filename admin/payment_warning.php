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
    "warning",
    "Urgence platby",
    "index.php",
    [
        "shooterID" => $shooterID,
        "shooterKEY" => $shooterKEY
    ],
    "Poslat závodníkovi #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")<br>upozornění na nezaplacení startovného.",
    "Pošleme závodníkovi upozornění na nezaplacení startovného.",
    "./send.php",
    "payment_warning",
    "Poslat urgenci platby"
);