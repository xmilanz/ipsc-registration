<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../db/dbconn.php';
require_once __DIR__ . '/../config/mail_texty.php';

$stmt = $conn->prepare("
SELECT * FROM match_config
      WHERE Zavod_id = ?
   ");
$stmt->bind_param(
    "s",
    $table
);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$match_data = mysqli_fetch_array($result);

// REGISTRACNI MAIL ODESLANY Z ADMINISTRACE
if (isset($_GET['regmail'])) {
    $line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

    $squad = $line['Squad'];
    $varsymbol = $line['VarSym'];

    $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

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

    // podmínky pro volbu textu v závislosti na statutu závodníka
    if (($line['Staff'] == "VIP") or ($line['Staff'] == "RO") or ($line['Staff'] == "POM")) {
        $message = $email_registrace_bez_platby_text_admin;
    } elseif ($line['ZaplatiNaMiste'] == "on") {
        $message = $email_registrace_platba_na_miste_admin;
    } elseif ($match_data['Payment_before'] == 'on') {
        $message = $email_registrace_platba_text_admin;
    } elseif ($line['Squad'] == "-2") {
        $message = $email_registrace_cekatel_text_admin;
    } else {
        $message = $email_registrace_zavod_bez_platby_predem_text_admin;
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
    // nice názvy pro mail

    $STRELEC .= "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
    $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " [$link_cancel]\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
    $STRELEC .= "Squad: $squad" . "\r\n\r\n";
    $STRELEC .= "<i>Rozhodčí: $Rozhodci" . "\r\n";
    $STRELEC .= "Pomocník: $Pomocnik</i>" . "\r\n";

    $qrParams = [
        'accountNumber' => $match_data['Banka_ucet_cislo'],
        'bankCode'      => $match_data['Banka_ucet_kod'],
        'amount'        => $match_data['Banka_ucet_CASTKA'],
        'currency'      => $match_data['Banka_ucet_MENA'],
        'vs'            => $varsymbol,
        'message'       => $match_data['Zavod'],
        'size'          => 100
    ];
    $qr_link = 'https://api.paylibo.com/paylibo/generator/czech/image?' . http_build_query($qrParams);

    $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
    $from = $match_data['Zavod_email_from'];
    $to = $line['Mail'];
    $subject = "Registrace " . $match_data['Zavod'];

    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
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
            "Pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu'>vývojáře</a> registračního systmu.",
            "Zpět do administrace"
        );
    } else {
        header("refresh:0;url=index.php");
        // informace o emailu zaslaneho z administrace se do databaze nezapisuje
    }
}


// URGENCE PLATBY
if (isset($_GET['payment_warn'])) {
    $line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

    $squad = $line['Squad'];
    $varsymbol = $line['VarSym'];

    $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

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

    // priprava podkladu pro email zavodnikovi
    // nice názvy pro mail
    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
    // nice názvy pro mail

    $STRELEC .= "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
    $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " [$link_cancel]\r\n";
    $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
    $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
    $STRELEC .= "Squad: $squad" . "\r\n\r\n";
    $STRELEC .= "<i>Rozhodčí: $Rozhodci" . "\r\n";
    $STRELEC .= "Pomocník: $Pomocnik</i>" . "\r\n";

    $qrParams = [
        'accountNumber' => $match_data['Banka_ucet_cislo'],
        'bankCode'      => $match_data['Banka_ucet_kod'],
        'amount'        => $match_data['Banka_ucet_CASTKA'],
        'currency'      => $match_data['Banka_ucet_MENA'],
        'vs'            => $varsymbol,
        'message'       => $match_data['Zavod'],
        'size'          => 100
    ];
    $qr_link = 'https://api.paylibo.com/paylibo/generator/czech/image?' . http_build_query($qrParams);


    $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
    $from = $match_data['Zavod_email_from'];
    $to = $line['Mail'];
    $subject = "Chybějící platba " . $match_data['Zavod'];

    $message = $email_urgence_platba_text_admin;
    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
    $message = str_replace("##QR_LINK##", $qr_link, $message);
    $message = str_replace("##DatReg##", $datumRegistraceZavodnika->format('d.m.Y'), $message);
    $message = str_replace("##DatPay##", $paymentDeadline, $message);

    $send_email = email($from_text, $from, $to, $subject, $message);
    if (!$send_email) {
        include './components/modal-warning.php';
        WarningModal(
            "danger",
            "Chyba odeslání emailu",
            "index.php",
            "Při odeslání emailu závodníkovi došlo k chybě.",
            "Závodník byl zaregistrován, pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu'>vývojáře</a> registračního systmu.",
            "Zpět do administrace"

        );
    } else {
        $dnes = date_format(new DateTime(), "d.m.Y H:i");
        //zapiseme do DB, kdy byla urgence odeslana
        $stmt = $conn->prepare("
            	UPDATE $table 
		        SET Urgence = ?
		        WHERE Cislo = ? and klic = ?
	            ");
        $stmt->bind_param(
            "sii",
            $dnes,
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
                "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>vývojáře</a> registračního systmu.",
                "Zpět do administrace"
            );
        } else {
            header("refresh:0;url=index.php");
        }
    }
}
