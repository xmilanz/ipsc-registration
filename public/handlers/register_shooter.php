<?php
// zkontrolovat max pocet ve squadu 
$_POST['Squad'] == 100 ? $squad_max = $match_data['Squad_prem_max'] : $squad_max = $match_data['Squad_main_max'];
$stmt = $conn->prepare("
		SELECT Count(Prijmeni) FROM $table
		WHERE Squad = ?
	 ");
$stmt->bind_param(
    "i",
    $_POST['Squad']
);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$line = mysqli_fetch_row($result);
$pocet = $line[0];
if ($pocet >= $squad_max) {
    include './components/modal-warning.php';
    WarningModal(
        "Neúspěšná registrace",
        "registrace.php",
        "<div class='col-12 fw-bolder text-danger'>Squad $_POST[Squad] je zaplněný",
        "Kliknutím na  tlačítko <kbd>Zpět na registraci</kbd> se vraťte do registrace<br>a zvolte nezaplněný squad.",
        "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět na registraci</button>",
        "$poradatel"
    );
    exit;
} else {
    $alias = trim(mb_convert_case($_POST['Alias'], MB_CASE_UPPER, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER);
    $jmeno = trim(mb_convert_case($_POST['Jmeno'] ?? '', MB_CASE_TITLE, "UTF-8"));
    $prijmeni = trim(mb_convert_case($_POST['Prijmeni'], MB_CASE_TITLE, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER) . $_POST['Prijmeni_stav'] . '';
    $email = trim($_POST['Email'] ?? '');
    $ip = $_SERVER["REMOTE_ADDR"];
    $op = normalizePrukaz($_POST['ObcanskyPrukaz'] ?? '');
    $zo = isset($_POST['ZbrojniOpravneni']) ? 1 : 0;
    $cz = normalizePrukaz(trim($_POST['CZ']) ?? '');
    $poznamka = trim($_POST['Poznamka'] ?? '');
    $staff = $_POST['Staff'] ?? '';

    $varsymbol = random_int(1000, 9999);
    $klic = random_int(1000, 9999);
    $datreg = time();

    empty($_POST['Divize']) ? $divize = substr($_POST['Divize_dalsi'], 1) : $divize = $_POST['Divize'];

    // ziskame castku startovneho
    $FeeStmt = $conn->prepare("SELECT * FROM $table_fee ORDER BY Count");
    $FeeStmt->execute();
    $feeValues = $FeeStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $FeeStmt->close();

    //kontrola, zda se zavodnik nepokousi opakovane vyrazovat a znovu registrovat (vice jak 1x)
    $stmt = $conn->prepare("
	 	SELECT count(Squad) as pocet FROM $table
	 	WHERE Squad='-9' AND Alias = ?
	 ");
    $stmt->bind_param(
        "s",
        $alias
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $countAliasVyrazeno = mysqli_fetch_assoc($result);

    if ($countAliasVyrazeno['pocet'] > 1) {
        include './components/modal-warning-extended.php';
        WarningModalExtended(
            "Neúspěšná registrace",
            "registrace.php",
            "<div class='col-12 fw-bolder text-danger'>Závodník $jmeno $prijmeni [$alias] je evidovaný jako dvakrát vyřazený.",
            "Opakované zrušení registrace a provedení nové se často dělá za účelem obcházení termínu pro zaplacení registrace. ",
            "Pokud si nejste vědomi, že byste <strong>již dvakrát zrušili svoji účast závodě</strong>, kontaktujte <a href='mailto:$match_data[Zavod_email_poradatel]?subject=Neúspěšná registrace - opakované vyřazení'>pořadatele</a> nebo <a href='mailto:$match_data[Zavod_email_stats]?subject=Neúspěšná registrace - opakované vyřazení'>statistika</a>.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět na registraci</button>",
            "$poradatel"
        );
        exit;
    }

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
            "Neúspěšná registrace",
            "registrace.php",
            "<div class='col-12 fw-bolder text-danger'>Závodník $jmeno $prijmeni ($alias) už je zaregistrovaný",
            "Buď vás už někdo zaregistroval nebo jste použili stejné jméno, příjmení a IPSC&nbsp;alias jako jiný závodník.<br>V případě, že jste zadali skutečně váš zaregistrovaný IPSC alias, kontaktujte <a href='mailto:$match_data[Zavod_email_poradatel]?subject=Neúspěšná registrace - duplicitní IPSC alias, prijmeni a jmeno'>pořadatele</a> nebo <a href='mailto:$match_data[Zavod_email_stats]?subject=Neúspěšná registrace - duplicitní IPSAC alias, prijmeni a jmeno'>statistika</a>.<br>Pokud jste zadali alias <strong>nezaregistrovaný na IPSC-TECH.ORG</strong>, použijte tento <a href='https://ipscresults.org/Mobile/AliasRegistration.html' target='_new'>odkaz</a> a&nbsp;zaregistrujte se. Pro odlišení napište za příjmení $prijmeni nějaký další znak<br><small> nebo z nabídky zvolte <b>ml./st.</b></small>
                            <p class='text-danger text-center mb-3 fst-italic'>Kombinaci <mark>Jméno Příjmení (ALIAS)</mark> byste měli používat v průběhu celé série závodu.</p>",
            "Kliknutím na tlačítko <kbd>Zpět na registraci</kbd> se vraťte na registraci.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět na registraci</button>",
            "$poradatel"
        );
        exit;
    }

    //kontrola, zda je závodnik s aliasem uz zaregistrovan (bez vyřazených)
    elseif ($alias == $line['Alias']) {
        include './components/modal-warning-extended.php';
        WarningModalExtended(
            "Neúspěšná registrace",
            "registrace.php",
            "<div class='col-12 fw-bolder text-danger'>Závodník aliasem $alias už je zaregistrovaný",
            "V případě, že jste zadali skutečně váš zaregistrovaný IPSC alias, <br>kontaktujte <a href='mailto:$match_data[Zavod_email_poradatel]?subject=Neúspěšná registrace - duplicitní IPSC alias'>pořadatele</a> nebo <a href='mailto:$match_data[Zavod_email_stats]?subject=Neúspěšná registrace - duplicitní alias'>statistika</a>.<br>Pokud jste zadali alias <strong>nezaregistrovaný na IPSC-TECH.ORG</strong>, <br>použijte tento <a href='https://ipscresults.org/Mobile/AliasRegistration.html' target='_new'>odkaz</a> a&nbsp;zaregistrujte se.<br>
                            <p class='text-danger text-center mb-3 fst-italic'>V průběhu celé série závodu byste měli používat stále stejný <mark>IPSC alias</mark>.</p>",
            "Kliknutím na tlačítko <kbd>Zpět na registraci</kbd> se vraťte na registraci.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'registrace.php';\">Zpět na registraci</button>",
            "$poradatel"
        );
        exit;
    } else {

        // konecne registrujeme zavodnika
        $stmt = $conn->prepare("
		    INSERT INTO $table 
		    (Alias,Prijmeni,Jmeno,ObcanskyPrukaz,ZbrojniOpravneni,CisloZbrane,VarSym,Region,Mail,Kategorie,Divize,Faktor,DatReg,RegistraceIP,Squad,Staff,klic,CastkaZaplatit,Poznamka,Zavod)
		    VALUES (?, ?, ?, NULLIF(?,''), NULLIF(?,''), NULLIF(?,''), ?, ?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?,''),?,?,?,?)
	");
        $stmt->bind_param(
            "ssssssisssssssisiiss",
            $alias,
            $prijmeni,
            $jmeno,
            $op,
            $zo,
            $cz,
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
            $klic,
            $feeValues[0]['Value'],
            $poznamka,
            $table
        );
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        $cislo = $conn->insert_id;

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
        $isVIP = in_array($line['Staff'], ['VIP', 'RO', 'POM']);

        $line['Staff'] == "RO" ? $Rozhodci = "ANO" : $Rozhodci = "NE";
        $line['Staff'] == "POM" ? $Pomocnik = "ANO" : $Pomocnik = "NE";
        $link_cancel = buildCancelLinks($reg_url, $cislo, $klic);
        $link_ical = buildCalendarLinks($reg_url, $match_data);

        // Uprava terminu zaplaceni závodníka, co se zaregistruje mene nez Zavod_pocet_dni_na_platbu dni pred prematchem
        $datumZavod = new DateTime($match_data['Zavod_datum']);
        $datumPrematch = (clone $datumZavod)->modify("-1 days");
        $datumRegistraceZavodnika = new DateTime();
        $datumRegistraceZavodnika->setTimestamp($line['DatReg']);

        if ($datumRegistraceZavodnika >= $datumPrematch->modify("-$match_data[Zavod_pocet_dni_na_platbu] days")) {
            $paymentDeadline = $datumZavod->modify("-2 days")->format('j.m.Y');
        } else {
            $paymentDeadline = (clone $datumRegistraceZavodnika)->modify("+$match_data[Zavod_pocet_dni_na_platbu] days")->format('j.m.Y');
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
        $CastkaZaplatit = ($isVIP) ? '0'  : number_format($feeValues[0]['Value'], 2, ',', ' ');

        // nice názvy pro mail
        $faktorLabels = [
            "MIN" => "Minor",
            "MAJ"  => "Major"
        ];

        $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');
        $line['Squad'] == "-2" ? $squads = "Čekatelé" : $squads = $squad;

        $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
        $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
        // nice názvy pro mail

        // zobrazime modal s informaci pro zavodnika
        $STRELEC_ALIAS = "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>";
        $STRELEC_SHOOTER = "Střelec: " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8');
        $STRELEC_CATEGORY = "Kategorie: $nazev_kategorie";
        $STRELEC_DIVISION = "Divize: $nazev_divize $faktorLabel";
        $STRELEC_SQUAD = "Squad: $squads";
        $STRELEC_RO = "Rozhodčí: $Rozhodci";
        $STRELEC_POM = "Pomocník: $Pomocnik";
        $STRELEC_CASTKA = "Částka: $CastkaZaplatit " . $match_data['Banka_ucet_MENA'] . "";
        $STRELEC_VS = "Variabilní symbol: $varsymbol";

        include './components/modal-warning.php';
        WarningModal(
            "Úspěšná registrace",
            "registrace.php",
            "<div class='col-12 fw-bolder text-danger'>Zaregistrovali jsme závodníka s těmito údaji<br>
                <div class='font-monospace d-inline-block text-start mt-2'>
                    $STRELEC_ALIAS<br>
                    $STRELEC_SHOOTER<br><br>
                    $STRELEC_SQUAD<br>
                    $STRELEC_DIVISION<br>
                    $STRELEC_CATEGORY<br><br>
                    $STRELEC_CASTKA<br>
                    $STRELEC_RO<br>
                    $STRELEC_POM
                </div>
                ",
            "Potvrzení registrace bylo odesláno na adresu $email",
            "<button type='button' class='btn btn-primary' onclick=\"window.location.href = 'registrace.php';\">Nová registrace</button>
             <button type='button' class='btn btn-outline-dark' onclick=\"window.location.href = 'index.php';\">Zavřít</button>",
            "$poradatel"
        );

        // posilame mail zavodnikovi
        $STRELEC = "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
        $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "  [$link_cancel] [$link_ical] " . "\r\n";
        $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
        $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
        $STRELEC .= "Squad: $squads" . "\r\n\r\n";
        $STRELEC .= "<i>Rozhodčí: $Rozhodci" . "\r\n";
        $STRELEC .= "Pomocník: $Pomocnik</i>" . "\r\n\r\n";
        $STRELEC .= "Poznámka: $poznamka</i>" . "\r\n";

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
        $dnes = date_format(new DateTime(), "j.n.Y H:i");
        $mena = $match_data['Banka_ucet_MENA'];

        // podmínky pro volbu textu v závislosti na statutu závodníka
        if (($line['Staff'] == "VIP") or ($line['Staff'] == "RO") or ($line['Staff'] == "POM")) {
            $message = $email_registrace_bez_platby_text;
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
        } elseif ($line['Squad'] == "-2") {
            $message = $email_registrace_cekatel_text;
        } elseif ($match_data['Payment_before'] == 1) {
            $message = $email_registrace_platba_text;
        } else {
            $message = $email_registrace_zavod_bez_platby_predem;
        }

        $message = str_replace("##STRELEC##", $STRELEC, $message);
        $message = str_replace("##VAR_SYMBOL##", $varsymbol, $message);
        $message = str_replace("##CASTKA##", $CastkaZaplatit, $message);
        $message = str_replace("##QR_LINK##", $qr_link, $message);
        $message = str_replace("##DatPay##", $paymentDeadline, $message);

        $send_email = email($from_text, $from, $to, $subject, $message);
        if (!$send_email) {
            include './components/modal-warning.php';
            WarningModal(
                "Chyba odeslání emailu",
                "index.php",
                "<div class='col-12 fw-bolder text-danger'>Při odeslání emailu došlo k chybě!",
                "Závodník je úspěšně zaregistrovaný. Kontaktujte <a href='mailto:" . htmlspecialchars($line['Zavod_email_poradatel'], ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu na [$email]'>pořadatele závodu</a>.",
                "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zpět</button>",
                "$poradatel"
            );
            exit;
        } else {
            //zapiseme do DB, ze registracni mail byl odeslan
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
            $stmt->close();
        }
    }
}
