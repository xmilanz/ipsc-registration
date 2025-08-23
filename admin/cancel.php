<?php
// HOTOVO REDESIGN A REFACTORING 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once("../db/dbconn.php");
require_once("../config/data.php");

$shooterID = intval($_GET['ID']);
$shooterKEY = intval($_GET['KEY']);

//$stmt = $conn->prepare("
//	SELECT * FROM $table 
//	WHERE Cislo = ? AND klic = ?
//	");
//$stmt->bind_param(
//    "ii",
//    $shooterID,
//    $shooterKEY
//);
//$stmt->execute();
//$result = $stmt->get_result();

//$line = mysqli_fetch_array($result);
$line = getShooterData($conn, $table, $shooterID, $shooterKEY);

include './components/modal-warning-form.php';
WarningModalForm(
    "secondary",
    "Vyřazení závodníka",
    "index.php",
    [
        "shooterID" => $shooterID,
        "shooterKEY" => $shooterKEY
    ],
    "Opravdu chcete vyřadit závodníka " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ").",
    "Závodník nebude odstraněn, ale přesunut do squadu VYŘAZENO (-2).",
    "./save.php?cancel_shooter",
    "Vyřadit závodníka"
);