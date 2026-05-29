<?php
$stmt = $conn->prepare("
        INSERT INTO $table_divisions 
        (Name,Value)
	    VALUES (?, ?)
	");
$stmt->bind_param(
    "ss",
    $_POST['Name'],
    $_POST['Value']
);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected === 0) {
    include './components/modal-warning.php';
    WarningModal(
        "danger",
        "Chyba databáze",
        "index.php",
        "Při vkládání do databáze došlo k chybě!",
        "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>vývojáře</a> registračního systému.",
        "Zpět do administrace"
    );
} else {
    $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Divize byla úspěšně přidána',
        'duration' => 2000
    ];
    header("Location: index.php?divisions");
}
