<?php
$line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

$dnes = date_format(new DateTime(), "d.m.Y H:i");
$ip = ($_SERVER["REMOTE_ADDR"] . " - admin");

$stmt = $conn->prepare("
		UPDATE $table 
		SET SquadReg = ?,
		Squad = '-9', 
        Staff = 'DNS',
        CastkaZaplatit = NULL,
		Vyrazeno = ?, 
		VyrazenoIP = ? 
		WHERE Cislo = ? AND klic = ?
	");
$stmt->bind_param(
    "sssii",
    $line['Squad'],
    $dnes,
    $ip,
    $_POST['shooterID'],
    $_POST['shooterKEY']
);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected == 0) {
    include './components/modal-warning.php';
    WarningModal(
        "danger",
        "Chyba databáze",
        "index.php",
        "Při vkládání do databáze došlo k chybě!",
        "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>vývojáře</a> registračního systému.",
        "Zpět do administrace"
    );
    exit;
} else {
    header("refresh:0;url=index.php");

    // příprava mailu zavodnikovi
    // nice názvy pro mail
    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");

    $STRELEC = "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
    $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";


    $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
    $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
    $to = $line['Mail'];
    $subject = "Zrušení registrace závodníka " . $match_data['Zavod'];
    $message = $email_text_vyrazeni;
    $message = str_replace("##STRELEC##", $STRELEC, $message);

    $send_email = email($from_text, $from, $to, $subject, $message);
    if (!$send_email) {
        include './components/modal-warning.php';
        WarningModal(
            "danger",
            "Chyba odeslání e-mailu",
            "index.php",
            "Při odeslání e-mailu závodníkovi došlo k chybě.",
            "Pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani e-mailu'>vývojáře</a> registračního systému.",
            "Zpět do administrace"
        );
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Závodník byl vyřazen a e-mail s informací odeslán.',
            'duration' => 3000
        ];
    }
    exit();
}
