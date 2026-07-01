<?php
$ip = ($_SERVER["REMOTE_ADDR"]);

$cislo = $_POST['shooterID'];
$klic = $_POST['shooterKEY'];

$line = getShooterData($conn, $table, $cislo, $klic);

$oldSquad = $line['Squad'];

// nice názvy pro mail
$faktorLabels = [
    "MIN" => "Minor",
    "MAJ"  => "Major"
];
$faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

$nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
$nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
// nice názvy pro mail

if (!$line) {
    include './components/modal-warning.php';
    WarningModal(
        "Vyřazení závodníka",
        "index.php",
        "<div class='col-12 fw-bolder text-danger'>Nelze dohledat závodníka.",
        "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba vyrazeni zavodnika'>pořadatele závodu</a>.",
        "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět</button>",
        "$poradatel"
    );
    exit;
} else {
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

    if ($affected === 0) {
        include './components/modal-warning.php';
        WarningModal(
            "Chyba databáze",
            "registrace.php",
            "<div class='col-12 fw-bolder text-danger'>Při vkládání do databáze došlo k chybě!",
            "Zkuste to později nebo kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>pořadatele závodu</a>.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět na registraci</button>",
            "$poradatel"
        );
        exit;
    } else {
        include './components/modal-warning.php';
        WarningModal(
            "Vyřazení závodníka",
            "index.php",
            "<div class='col-12 fw-bolder text-danger'>Závodník #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")<br>byl vyřazen ze závodu $match_data[Zavod].",
            "Email s informací byl odeslán na adresu " . htmlspecialchars($line['Mail'], ENT_QUOTES, 'UTF-8') . " zadanou při registraci.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zavřít</button>",
            "$poradatel"
        );
    }
    // posilame mail vyřazenému zavodnikovi
    $STRELEC = "IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
    $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";

    $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
    $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
    $to = htmlspecialchars($line['Mail'], ENT_QUOTES, 'UTF-8');
    $subject = "Zrušení registrace závodníka " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');
    $message = $email_text_vyrazeni_vlastni;
    $message = str_replace("##STRELEC##", $STRELEC, $message);

    $send_email = email($from_text, $from, $to, $subject, $message);
    if (!$send_email) {
        include './components/modal-warning.php';
        WarningModal(
            "Chyba odeslání emailu",
            "index.php",
            "<div class='col-12 fw-bolder text-danger'>Při odeslání emailu došlo k chybě!",
            "Závodník je vyřazený. Kontaktujte <a href='mailto:" . htmlspecialchars($line['Zavod_email_poradatel'], ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu na [$email]'>pořadatele závodu</a>.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zpět</button>",
            "$poradatel"
        );
    }

    // pokud existje ve squadu Cekatel zavodnik, priradit jej na uvolnene misto
    $stmt = $conn->prepare("
        SELECT * FROM $table WHERE Squad = '-2' ORDER BY DatReg ASC LIMIT 1
       ");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $cekatel = mysqli_fetch_assoc($result);
    if (!$cekatel) {
        exit;
    } else {
        $stmt = $conn->prepare("
        UPDATE $table 
        SET Squad = ?
        WHERE Cislo = ?
    ");
        $stmt->bind_param(
            "ii",
            $oldSquad,
            $cekatel['Cislo']
        );
        $stmt->execute();
        $stmt->close();
    }

    // posíláme mail přesunutému čekateli
    $cekatel['Staff'] == "RO" ? $Rozhodci = "ANO" : $Rozhodci = "NE";
    $cekatel['Staff'] == "POM" ? $Pomocnik = "ANO" : $Pomocnik = "NE";

    // Uprava terminu zaplaceni závodníka, co je zaregistrovan mene nez Zavod_pocet_dni_na_platbu dni pred prematchem
    $datumZavod = new DateTime($match_data['Zavod_datum']);
    $datumPrematch = (clone $datumZavod)->modify("-1 days");
    $datumRegistraceZavodnika = new DateTime();
    $datumRegistraceZavodnika->setTimestamp($cekatel['DatReg']);

    if ($datumRegistraceZavodnika >= $datumPrematch->modify("-$match_data[Zavod_pocet_dni_na_platbu] days")) {
        $paymentDeadline = $datumZavod->modify("-2 days")->format('d.m.Y');
    } else {
        $paymentDeadline = (clone $datumRegistraceZavodnika)->modify("+$match_data[Zavod_pocet_dni_na_platbu] days")->format('d.m.Y');
    }

    $FeeStmt = $conn->prepare("SELECT * FROM $table_fee ORDER BY Count");
    $FeeStmt->execute();
    $feeValues = $FeeStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $FeeStmt->close();
    $castka = $feeValues[0]['Value'];

    $dnes = date_format(new DateTime(), "d.m.Y H:i");
    $mena = $match_data['Banka_ucet_MENA'];
    $varsymbol = $cekatel['VarSym'];

    $link_cancel = buildCancelLinks($reg_url, $cislo, $klic);
    $link_ical = buildCalendarLinks($reg_url, $match_data);


    // priprava podkladu pro email zavodnikovi
    // nice názvy pro mail
    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$cekatel['Faktor']] ?? htmlspecialchars($cekatel['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $cekatel['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $cekatel['Kategorie'], "Value");

    $STRELEC = "<strong>IPSC alias: " . htmlspecialchars($cekatel['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
    $STRELEC .= "Střelec: #" . $cekatel['Cislo'] . " " . htmlspecialchars($cekatel['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($cekatel['Prijmeni'], ENT_QUOTES, 'UTF-8') . "  [$link_cancel] [$link_ical] " . "\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
    $STRELEC .= "Squad: $oldSquad" . "\r\n\r\n";
    $STRELEC .= "<i>Rozhodčí: $Rozhodci" . "\r\n";
    $STRELEC .= "Pomocník: $Pomocnik</i>" . "\r\n";

    $qrParams = [
        'accountNumber' => $match_data['Banka_ucet_cislo'],
        'bankCode'      => $match_data['Banka_ucet_kod'],
        'amount'        => $feeValues[0]['Value'],
        'currency'      => $match_data['Banka_ucet_MENA'],
        'vs'            => $varsymbol,
        'message'       => $match_data['Zavod'],
        'size'          => 100
    ];
    $qr_link = 'https://api.paylibo.com/paylibo/generator/czech/image?' . http_build_query($qrParams);

    $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
    $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
    $to = $cekatel['Mail'];
    $subject = "Změna registrace " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');

    // podmínky pro volbu textu v závislosti na statutu závodníka
    if ($match_data['Payment_before'] == 1) {
        $message = $email_registrace_cekatel_presun_bez_platby_predem;
    } elseif ($naMiste == 1) {
        $message = $email_registrace_cekatel_presun_platba_na_miste;
    } else {
        $message = $email_registrace_cekatel_presun_platba;
    }

    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
    $message = str_replace("##CASTKA##", $castka, $message);
    $message = str_replace("##QR_LINK##", $qr_link, $message);
    $message = str_replace("##DatPay##", $paymentDeadline, $message);
    $message = str_replace("##SQUAD##", $oldSquad, $message);

    $send_email = email($from_text, $from, $to, $subject, $message);

    // odešleme pořadateli mail
    $VYRAZENY_UZIVATEL = "- IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
    $VYRAZENY_UZIVATEL .= "- Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " \r\n";

    $PRESUNUTY_CEKATEL = "- IPSC alias: " . htmlspecialchars($cekatel['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
    $PRESUNUTY_CEKATEL .= "- Střelec: #" . $cekatel['Cislo'] . " " . htmlspecialchars($cekatel['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($cekatel['Prijmeni'], ENT_QUOTES, 'UTF-8') . " \r\n";

    $message = "$email_automaticky_presun_cekatele";
    $message = str_replace("##VYRAZENY_UZIVATEL##", $VYRAZENY_UZIVATEL, $message);
    $message = str_replace("##PRESUNUTY_CEKATEL##", $PRESUNUTY_CEKATEL, $message);
    $message = str_replace("##SQUAD##", $oldSquad, $message);

    $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
    $to = htmlspecialchars($match_data['Zavod_email_stats'], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - automatický přesun čekatele #" . $cekatel['Cislo'];

    $send_email = email($from_text, $from, $to, $subject, $message);
}
exit();
