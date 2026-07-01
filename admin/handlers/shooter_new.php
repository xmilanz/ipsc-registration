<?php
$alias = trim(mb_convert_case($_POST['Alias'], MB_CASE_UPPER, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER);
$jmeno = trim(mb_convert_case($_POST['Jmeno'], MB_CASE_TITLE, "UTF-8"));
$prijmeni = trim(mb_convert_case($_POST['Prijmeni'], MB_CASE_TITLE, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER) . $_POST['Prijmeni_stav'] . '';
$ip = ($_SERVER["REMOTE_ADDR"] . " - admin");
$op = trim($_POST['ObcanskyPrukaz'] ?? '');
$zo = isset($_POST['ZbrojniOpravneni']) ? 1 : 0;
$cz = normalizePrukaz(trim($_POST['CZ']) ?? '');
$email = trim($_POST['Mail']);
$namiste = isset($_POST['ZaplatiNaMiste']) ? 1 : 0;
$varsymbol = rand(1000, 9999);
$klic = rand(1000, 9999);
$datreg = time();

empty($_POST['Divize']) ? $divize = substr($_POST['Divize_dalsi'], 1) : $divize = $_POST['Divize'];
// ziskame castku startovneho
$FeeStmt = $conn->prepare("SELECT * FROM $table_fee ORDER BY Count");
$FeeStmt->execute();
$feeValues = $FeeStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$FeeStmt->close();

//kontrola, zda je závodnik se jmenem, prijmenim a aliasem zaregistrovan (bez vyřazených)
$stmt = $conn->prepare("
   SELECT Alias,Prijmeni,Jmeno FROM $table
   WHERE ((Alias = ?) OR (Jmeno = ? AND Prijmeni = ?)) AND Squad >-2
   ");
$stmt->bind_param(
    "sss",
    $alias,
    $jmeno,
    $prijmeni
);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$line = mysqli_fetch_array($result);

if ($prijmeni == $line['Prijmeni'] and $jmeno == $line['Jmeno'] and $alias == $line['Alias']) {
    include './components/modal-warning-extended.php';
    WarningModalExtended(
        "danger",
        "Neúspěšná registrace",
        "index.php",
        "Závodník $jmeno $prijmeni ($alias) už je zaregistrovaný",
        "Pokud závodníka registrujete do další divize, použijte volbu 'Další&nbsp;divize'. Pro odlišení závodníka lze použít za příjmení nějaký další znak (číslo) nebo zvolit <b>ml./st.</b></small>",
        "Kombinaci <strong>Jméno Příjmení (ALIAS)</strong> je třeba používat v průběhu celé série závodu.",
        "Zpět do administrace",
        "$poradatel"
    );
}

//kontrola, zda je závodnik s aliasem uz zaregistrovan (bez vyřazených)
elseif ($alias == $line['Alias']) {
    include './components/modal-warning-extended.php';
    WarningModalExtended(
        "danger",
        "Neúspěšná registrace",
        "index.php",
        "Závodník s aliasem $alias už je zaregistrovaný",
        "Pokud je alias skutečně zaregistrovaný na na IPSC-TECH.ORG, kontaktujte závodníka.",
        "Kombinaci <strong>Jméno Příjmení (ALIAS)</strong> je třeba používat v průběhu celé série závodu.",
        "Zpět do administrace",
        "$poradatel"
    );
} else {

    // konecne registrujeme zavodnika
    $stmt = $conn->prepare("
		INSERT INTO $table 
        (Alias,Prijmeni,Jmeno,ObcanskyPrukaz,ZbrojniOpravneni,VarSym,Region,Mail,Kategorie,Divize,Faktor,DatReg,RegistraceIP,Squad,Staff,ZaplatiNaMiste,klic,CastkaZaplatit,Poznamka,Zavod)
        VALUES (?, ?, ?, NULLIF(?,''), NULLIF(?,''), ?, ?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?,''),NULLIF(?,''),?,?,?,?)
        ");
    $stmt->bind_param(
        "sssssisssssssisiiiss",
        $alias,
        $prijmeni,
        $jmeno,
        $op,
        $zo,
        $varsymbol,
        $_POST['Region'],
        $email,
        $_POST['Kategorie'],
        $divize,
        $_POST['Faktor'],
        $datreg,
        $ip,
        $_POST['Squad'],
        $_POST['Staff'],
        $namiste,
        $klic,
        $feeValues[0]['Value'],
        $_POST['Poznamka'],
        $table
    );
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    $cislo = $conn->insert_id;

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
    }

    // posilame potvrzeni registrace a platebni udaje zavodnihovi vcetne  odkazu na spravu ucasti (zruseni)
    $stmt = $conn->prepare("
		SELECT * FROM $table
		WHERE Prijmeni = ? and Jmeno = ? and VarSym = ? and  Mail = ?
	    ");
    $stmt->bind_param(
        "ssis",
        $prijmeni,
        $jmeno,
        $varsymbol,
        $email
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $line = mysqli_fetch_array($result);
    $squad = $line['Squad'];

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

    $tyden = intval(date("W", strtotime($match_data['Zavod_datum'])));
    $varsymbol_new = sprintf("%02d%04d", $tyden, $cislo);


    $stmt = $conn->prepare("
		UPDATE $table 
		SET VarSym = ?,
		DatPay = ?
		WHERE VarSym = ?
	    ");
    $stmt->bind_param(
        "isi",
        $varsymbol_new,
        $paymentDeadline,
        $varsymbol
    );
    $stmt->execute();
    $stmt->close();

    $varsymbol = $varsymbol_new;
    $dnes = date_format(new DateTime(), "d.m.Y H:i");
    $mena = $match_data['Banka_ucet_MENA'];
    $CastkaZaplatit = ($isVIP) ? '0'  : number_format($feeValues[0]['Value'], 2, ',', ' ');

    $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

    // nice názvy pro mail
    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];

    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');
    $squad == "-2" ? $squads = "Čekatelé" : $squads = $squad;

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");

    // podmínky pro volbu textu v závislosti na statutu závodníka
    if (($line['Staff'] == "VIP") or ($line['Staff'] == "RO") or ($line['Staff'] == "POM")) {
        $message = $email_registrace_bez_platby_text_novy_zavodnik;
        $stmt = $conn->prepare("
		    UPDATE $table 
		    SET Zaplaceno = 1,
            Castka = 0,
            Mena = ?, 
            DatumZaplaceni = ?
            WHERE Cislo = ? and klic = ?
	       ");
        $stmt->bind_param(
            "ssii",
            $mena,
            $dnes,
            $line['Cislo'],
            $line['klic']
        );
        $stmt->execute();
        $stmt->close();
    } elseif ($line['ZaplatiNaMiste'] == 1) {
        $message = $email_registrace_platba_na_miste_novy_zavodnik;
    } elseif ($squad == "-2") {
        $message = $email_registrace_cekatel_text_novy_zavodnik;
    } elseif ($match_data['Payment_before'] == 1) {
        $message = $email_registrace_platba_text;
    } else {
        $message = $email_registrace_zavod_bez_platby_predem;
    }

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
    $subject = "Registrace " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');
    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
    $message = str_replace("##CASTKA##", $CastkaZaplatit, $message);
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
        // zapiseme do DB, ze registracni mail byl odeslan
        $stmt = $conn->prepare("
		UPDATE $table 
		SET OdeslanRegMail = 1
		WHERE Mail = ? AND OdeslanRegMail IS NULL
	        ");
        $stmt->bind_param(
            "s",
            $email
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows === 0) {
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
            logAction("shooter new");
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Závodník byl úspěšně přidán a registrační email odeslán.',
                'duration' => 2000
            ];
            header("refresh:0;url=index.php");
        }
    }
}
