<?php
$alias = trim(mb_convert_case($_POST['Alias'], MB_CASE_UPPER, "UTF-8"));
$jmeno = trim(mb_convert_case($_POST['Jmeno'], MB_CASE_TITLE, "UTF-8"));
$prijmeni = trim(mb_convert_case($_POST['Prijmeni'], MB_CASE_TITLE, "UTF-8")) . $_POST['Prijmeni_stav'] . '';
$staff = $_POST['Staff'];
$squad = $_POST['Squad'];
$op = normalizePrukaz($_POST['ObcanskyPrukaz'] ?? '');
$zo = isset($_POST['ZbrojniOpravneni']) ? 1 : 0;
$naMiste = isset($_POST['ZaplatiNaMiste']) ? 1 : 0;
$email = trim($_POST['Mail']);
$mena = $match_data['Banka_ucet_MENA'];
$dnes = date_format(new DateTime(), "d.m.Y H:i");

$stmt = $conn->prepare("
		SELECT * FROM $table
		WHERE Prijmeni = ? and Jmeno = ? and  Mail = ?
	    ");
$stmt->bind_param(
    "sss",
    $prijmeni,
    $jmeno,
    $email
);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$line = mysqli_fetch_array($result);

//ziskani puvodnich hodnot pro kontrolu zmeny statu a VIP statusu
$oldStaff = $line['Staff'];
$oldSquad = $line['Squad'];

$wasVIP = in_array($oldStaff, ['VIP', 'RO', 'POM']);
$isVIP = in_array($staff, ['VIP', 'RO', 'POM']);

$FeeStmt = $conn->prepare("SELECT * FROM $table_fee ORDER BY Count");
$FeeStmt->execute();
$feeValues = $FeeStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$FeeStmt->close();
$castka = $feeValues[0]['Value'];

// editace vyrazeného zavodnika (Squad -9) bez změny statutu (DNS) 
/* - HOTOVO, FUNGUJE */
if (
    $squad == "-9" &&
    $staff == "DNS"
) {
    $stmt = $conn->prepare("
    UPDATE $table 
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        Zaplaceno = NULLIF(?,''), 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "ssssssssssssisi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $_POST['Zaplaceno'],
        $_POST['Poznamka'],
        $_POST['shooterID']
    );

    // editace vyrazeného zavodnika (Squad -9) -> platící (Staff = PAY) – nastavíme CastkaZaplatit a změníme Staff = PAY

} else if (
    $oldSquad == "-9" &&
    $staff == "PAY"
) {
    $stmt = $conn->prepare("
    UPDATE $table 
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        CastkaZaplatit = ?,
        Zaplaceno = NULLIF(?,''), 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "ssssssssssssiisi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $castka,
        $_POST['Zaplaceno'],
        $_POST['Poznamka'],
        $_POST['shooterID']
    );

    // vyrazený (Squad = -9) -> VIP/RO/POM – CastkaZaplatit = 0, Zaplaceno = 1
} else if (
    $oldSquad == "-9" &&
    $isVIP
) {
    $stmt = $conn->prepare("
    UPDATE $table 
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        CastkaZaplatit = 0,
        Zaplaceno = 1, 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "sssssssssssssi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $_POST['Poznamka'],
        $_POST['shooterID']
    );

    // aktivní neplatici VIP -> PAY (Squad != -9) -  – CastkaZaplatit = $castka, Zaplaceno = 0
} else if (
    ($squad != "-9") &&
    $wasVIP &&
    ($staff == "PAY")
) {
    $stmt = $conn->prepare("
    UPDATE $table
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        CastkaZaplatit = ?,
        Zaplaceno = 0,
        ZaplatiNaMiste = NULLIF(?,''), 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "ssssssssssssiisi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $castka,
        $naMiste,
        $_POST['Poznamka'],
        $_POST['shooterID']
    );

    // aktivní platici PAY -> VIP (Squad != -9) -  CastkaZaplatit = 0, Zaplaceno = 1
} else if (
    ($squad != "-9") &&
    $isVIP &&
    ($staff != "PAY")
) {
    $stmt = $conn->prepare("
    UPDATE $table 
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        CastkaZaplatit = 0,
        Zaplaceno = 1,
        ZaplatiNaMiste = NULLIF(?,''), 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "ssssssssssssisi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $naMiste,
        $_POST['Poznamka'],
        $_POST['shooterID']
    );

    // default – aktivní neVIP, různé kombinace PAY/DNS atd.
} else {
    $stmt = $conn->prepare("
    UPDATE $table 
    SET Alias = ?,
        Jmeno = ?,
        Prijmeni = ?,
        ObcanskyPrukaz = ?,
        ZbrojniOpravneni = ?,
        Mail = ?,
        Divize = ?,
        Kategorie = ?,
        Faktor = ?,
        Region = ?,
        Squad = ?,
        Staff = ?,
        Zaplaceno = NULLIF(?,''), 
        ZaplatiNaMiste = NULLIF(?,''), 
        Poznamka = ?
    WHERE Cislo = ?
    ");
    $stmt->bind_param(
        "ssssssssssssiisi",
        $alias,
        $jmeno,
        $prijmeni,
        $op,
        $zo,
        $email,
        $_POST['Divize'],
        $_POST['Kategorie'],
        $_POST['Faktor'],
        $_POST['Region'],
        $squad,
        $staff,
        $_POST['Zaplaceno'],
        $naMiste,
        $_POST['Poznamka'],
        $_POST['shooterID']
    );
}
$stmt->execute();
session_start();
if ($stmt->errno !== 0) {
    include './components/modal-warning.php';
    WarningModal(
        "danger",
        "Chyba databáze",
        "index.php",
        "Při vkládání do databáze došlo k chybě!",
        "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>vývojáře</a> registračního systému.",
        "Zpět do administrace"
    );
} elseif ($stmt->affected_rows === 0) {
    $_SESSION['toast'] = [
        'type' => 'primary',
        'message' => 'V nastavení závodníka jste neprovedli žádné změny.',
        'duration' => 2000
    ];
} else {
    $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Změny nastavení závodníka byly úspěšně uloženy.',
        'duration' => 2500
    ];
}
$stmt->close();
header("Location: /");

// přesun čekatele do běžného squadu

if (
    $oldSquad == "-2" &&
    ($oldSquad != $squad)
) {
    $line['Staff'] == "RO" ? $Rozhodci = "ANO" : $Rozhodci = "NE";
    $line['Staff'] == "POM" ? $Pomocnik = "ANO" : $Pomocnik = "NE";

    // Uprava terminu zaplaceni závodníka, co je zaregistrovan mene nez Zavod_pocet_dni_na_platbu dni pred prematchem
    $datumZavod = new DateTime($match_data['Zavod_datum']);
    $datumPrematch = (clone $datumZavod)->modify("-1 days");
    $datumRegistraceZavodnika = new DateTime();
    $datumRegistraceZavodnika->setTimestamp($line['DatReg']);

    if ($datumRegistraceZavodnika >= $datumPrematch->modify("-$match_data[Zavod_pocet_dni_na_platbu] days")) {
        $paymentDeadline = $datumZavod->modify("-2 days")->format('d.m.Y');
    } else {
        $paymentDeadline = (clone $datumRegistraceZavodnika)->modify("+$match_data[Zavod_pocet_dni_na_platbu] days")->format('d.m.Y');
    }

    $dnes = date_format(new DateTime(), "d.m.Y H:i");
    $mena = $match_data['Banka_ucet_MENA'];
    $varsymbol = $line['VarSym'];

    $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

    // podmínky pro volbu textu v závislosti na statutu závodníka
    if ($match_data['Payment_before'] == 1) {
        $message = $email_registrace_cekatel_presun_bez_platby_predem;
    } elseif ($naMiste == 1) {
        $message = $email_registrace_cekatel_presun_platba_na_miste;
    } else {
        $message = $email_registrace_cekatel_presun_platba;
    }

    // priprava podkladu pro email zavodnikovi
    // nice názvy pro mail
    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");

    $STRELEC = "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
    $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " [$link_cancel]\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
    $STRELEC .= "Squad: $squad" . "\r\n\r\n";
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
    $to = $email;
    $subject = "Změna registrace " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');
    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
    $message = str_replace("##CASTKA##", $castka, $message);
    $message = str_replace("##Squad##", $squad, $message);
    $message = str_replace("##QR_LINK##", $qr_link, $message);
    $message = str_replace("##DatPay##", $paymentDeadline, $message);

    $send_email = email($from_text, $from, $to, $subject, $message);
    if (!$send_email) {
        include './components/modal-warning.php';
        WarningModal(
            "danger",
            "Chyba odeslání emailu",
            "index.php",
            "Při odeslání emailu závodníkovi došlo k chybě.",
            "Závodník byl zaregistrován, pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu'>vývojáře</a> registračního systému.",
            "Zpět do administrace"
        );
    } else {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Čekatel byl přesunut do běžného squadu.',
            'duration' => 2000
        ];
    }
    // konec přesun čekatele do běžného squadu
    exit();
}
?>