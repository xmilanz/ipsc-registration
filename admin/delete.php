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

$line = getShooterData($conn, $table, $shooterID, $shooterKEY);

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
//
//$line = mysqli_fetch_array($result);

include './components/modal-warning-form.php';
WarningModalForm(
    "danger",
    "Mazání závodníka",
    "index.php",
    [
        "shooterID" => $shooterID,
        "shooterKEY" => $shooterKEY
    ],
    "Opravdu chcete smazat závodníka " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")?",
    "Tato akce je nevratná, rozmyslete si to pořádně!!!",
    "./save.php?delete_shooter",
    "Smazat závodníka"
);