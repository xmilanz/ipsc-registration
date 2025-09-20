<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
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

$conn = new mysqli($db_host, $db_login, $db_pass, $db_dtb);



// KONFIGRACE ZAVODU 
if (isset($_GET['match_config'])) {
    if ($match_data['Payment_before'] == "on") {
        $stmt = $conn->prepare("
	UPDATE match_config 
        SET Banka_ucet_CASTKA = ?,
   	 Banka_ucet_cislo = ?,
   	 Banka_ucet_kod = ?,
   	 Banka_nazev = ?,
   	 Banka_adresa = ?,
   	 Klub_web = ?,
   	 Zavod = ?,
   	 Zavod_datum = ?,
   	 Zavod_cas_registrace = ?,
   	 Zavod_zacatek_registrace = ?,
   	 Zavod_konec_registrace = ?,
   	 Zavod_registrace_pozastaveno = ?,
   	 Zavod_more_divisions = ?,
   	 Zavod_zobrazovat_sponzory = ?,
   	 Zavod_zbrojni_prukaz = ?,
   	 Web_zobrazovat_situace = ?,
   	 Web_zobrazovat_aliasy = ?,
   	 Zavod_cas_prematch = ?,
   	 Zavod_cas_prezence = ?,
   	 Zavod_cas_main = ?,
   	 Zavod_cas_main_dopoledne = ?,
   	 Zavod_cas_main_odpoledne = ?,
   	 Zavod_misto = ?,
   	 Zavod_misto_mapa = ?,
   	 Zavod_poradatel = ?,
   	 Zavod_poradatel_adresa = ?,
   	 Zavod_match_director = ?,
   	 Zavod_email_poradatel = ?,
   	 Zavod_telefon_poradatel = ?,
   	 Zavod_range_master = ?,
   	 Zavod_email_range_master = ?,
   	 Zavod_telefon_range_master = ?,
   	 Zavod_stats = ?,
   	 Zavod_email_stats = ?,
   	 Zavod_telefon_stats = ?,
   	 Zavod_hospodar = ?,
   	 Zavod_email_hospodar = ?,
   	 Zavod_telefon_hospodar = ?,
   	 Zavod_email_from = ?,
   	 Zavod_stages = ?,
   	 Zavod_min_pocet_ran = ?,
   	 Zavod_pocet_dni_na_platbu = ?,
   	 Zavod_vysledky = ?,
   	 Squad_main_max = ?,
   	 Squad_prem_max = ?,
   	 Payment_before = ?
    WHERE Zavod_id = ?
    ");
        $stmt->bind_param(
            "sssssssssssssssssssssssssssssssssssssssiiisiiss",
            $_POST['Banka_ucet_CASTKA'],
            $_POST['Banka_ucet_cislo'],
            $_POST['Banka_ucet_kod'],
            $_POST['Banka_nazev'],
            $_POST['Banka_adresa'],
            $_POST['Klub_web'],
            $_POST['Zavod'],
            $_POST['Zavod_datum'],
            $_POST['Zavod_cas_registrace'],
            $_POST['Zavod_zacatek_registrace'],
            $_POST['Zavod_konec_registrace'],
            $_POST['Zavod_registrace_pozastaveno'],
            $_POST['Zavod_more_divisions'],
            $_POST['Zavod_zobrazovat_sponzory'],
            $_POST['Zavod_zbrojni_prukaz'],
            $_POST['Web_zobrazovat_situace'],
            $_POST['Web_zobrazovat_aliasy'],
            $_POST['Zavod_cas_prematch'],
            $_POST['Zavod_cas_prezence'],
            $_POST['Zavod_cas_main'],
            $_POST['Zavod_cas_main_dopoledne'],
            $_POST['Zavod_cas_main_odpoledne'],
            $_POST['Zavod_misto'],
            $_POST['Zavod_misto_mapa'],
            $_POST['Zavod_poradatel'],
            $_POST['Zavod_poradatel_adresa'],
            $_POST['Zavod_match_director'],
            $_POST['Zavod_email_poradatel'],
            $_POST['Zavod_telefon_poradatel'],
            $_POST['Zavod_range_master'],
            $_POST['Zavod_email_range_master'],
            $_POST['Zavod_telefon_range_master'],
            $_POST['Zavod_stats'],
            $_POST['Zavod_email_stats'],
            $_POST['Zavod_telefon_stats'],
            $_POST['Zavod_hospodar'],
            $_POST['Zavod_email_hospodar'],
            $_POST['Zavod_telefon_hospodar'],
            $_POST['Zavod_email_from'],
            $_POST['Zavod_stages'],
            $_POST['Zavod_min_pocet_ran'],
            $_POST['Zavod_pocet_dni_na_platbu'],
            $_POST['Zavod_vysledky'],
            $_POST['Squad_main_max'],
            $_POST['Squad_prem_max'],
            $_POST['Payment_before'],
            $table
        );
    } else {
        $stmt = $conn->prepare("
	UPDATE match_config 
        SET Banka_ucet_CASTKA = ?,
     Klub_web = ?,
     Zavod = ?,
     Zavod_datum = ?,
     Zavod_cas_registrace = ?,
     Zavod_zacatek_registrace = ?,
     Zavod_konec_registrace = ?,
     Zavod_registrace_pozastaveno = ?,
     Zavod_more_divisions = ?,
     Zavod_zobrazovat_sponzory = ?,
     Zavod_zbrojni_prukaz = ?,
     Web_zobrazovat_situace = ?,
     Web_zobrazovat_aliasy = ?,
     Zavod_cas_prematch = ?,
     Zavod_cas_prezence = ?,
     Zavod_cas_main = ?,
     Zavod_cas_main_dopoledne = ?,
     Zavod_cas_main_odpoledne = ?,
     Zavod_misto = ?,
     Zavod_misto_mapa = ?,
     Zavod_poradatel = ?,
     Zavod_poradatel_adresa = ?,
     Zavod_match_director = ?,
     Zavod_email_poradatel = ?,
     Zavod_telefon_poradatel = ?,
     Zavod_range_master = ?,
     Zavod_email_range_master = ?,
     Zavod_telefon_range_master = ?,
     Zavod_stats = ?,
     Zavod_email_stats = ?,
     Zavod_telefon_stats = ?,
     Zavod_hospodar = ?,
     Zavod_email_hospodar = ?,
     Zavod_telefon_hospodar = ?,
     Zavod_email_from = ?,
     Zavod_stages = ?,
     Zavod_min_pocet_ran = ?,
     Zavod_pocet_dni_na_platbu = ?,
     Zavod_vysledky = ?,
     Squad_main_max = ?,
     Squad_prem_max = ?,
     Payment_before = ?
    WHERE Zavod_id = ?
    ");
        $stmt->bind_param(
            "sssssssssssssssssssssssssssssssssssiiisiiss",
            $_POST['Banka_ucet_CASTKA'],
            $_POST['Klub_web'],
            $_POST['Zavod'],
            $_POST['Zavod_datum'],
            $_POST['Zavod_cas_registrace'],
            $_POST['Zavod_zacatek_registrace'],
            $_POST['Zavod_konec_registrace'],
            $_POST['Zavod_registrace_pozastaveno'],
            $_POST['Zavod_more_divisions'],
            $_POST['Zavod_zobrazovat_sponzory'],
            $_POST['Zavod_zbrojni_prukaz'],
            $_POST['Web_zobrazovat_situace'],
            $_POST['Web_zobrazovat_aliasy'],
            $_POST['Zavod_cas_prematch'],
            $_POST['Zavod_cas_prezence'],
            $_POST['Zavod_cas_main'],
            $_POST['Zavod_cas_main_dopoledne'],
            $_POST['Zavod_cas_main_odpoledne'],
            $_POST['Zavod_misto'],
            $_POST['Zavod_misto_mapa'],
            $_POST['Zavod_poradatel'],
            $_POST['Zavod_poradatel_adresa'],
            $_POST['Zavod_match_director'],
            $_POST['Zavod_email_poradatel'],
            $_POST['Zavod_telefon_poradatel'],
            $_POST['Zavod_range_master'],
            $_POST['Zavod_email_range_master'],
            $_POST['Zavod_telefon_range_master'],
            $_POST['Zavod_stats'],
            $_POST['Zavod_email_stats'],
            $_POST['Zavod_telefon_stats'],
            $_POST['Zavod_hospodar'],
            $_POST['Zavod_email_hospodar'],
            $_POST['Zavod_telefon_hospodar'],
            $_POST['Zavod_email_from'],
            $_POST['Zavod_stages'],
            $_POST['Zavod_min_pocet_ran'],
            $_POST['Zavod_pocet_dni_na_platbu'],
            $_POST['Zavod_vysledky'],
            $_POST['Squad_main_max'],
            $_POST['Squad_prem_max'],
            $_POST['Payment_before'],
            $table
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
            'message' => 'V nastavení závodu jste neprovedli žádné změny.'
        ];
    } else {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Změny nastavení závodu byly úspěšně uloženy.'
        ];
    }
    $stmt->close();
    header("Location: index.php");
    exit();
}

// PRIDANI NOVEHO UZIVATELE - TO-DO - omezení přístupu uživatele na konkrétní závod
if (isset($_GET['new_user'])) {
    $username = $_POST['Username'] ?? '';
    $password = $_POST['Heslo'] ?? '';
    $jmeno = $_POST['Jmeno'] ?? '';
    $prijmeni = $_POST['Prijmeni'] ?? '';
    $email = $_POST['Mail'] ?? '';
    $role = $_POST['Role'] ?? 'viewer';

    if ($username && $password && isValidPassword($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO site_admins (username, email, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email,  $hash, $jmeno, $prijmeni, $role);
        $stmt->execute();
        $stmt->close();
    } else {
        $_SESSION['toast'] = [
            'type' => 'warning',
            'message' => 'Heslo musí mít 8–16 znaků, obsahovat číslo a speciální znak.'
        ];
        header("Location: index.php?users");
        exit();
    }
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
            'message' => 'Uživatel byl úspěšně přidán.'
        ];
        header("Location: index.php?users");
        //pri odešleme uživateli mail
        $UZIVATEL .= "Jméno pro přihlášení:" . $username  . "\r\n";
        $UZIVATEL .= "Heslo: pošle administrátor jinou cestou \r\n";
        $UZIVATEL .= "Role: " . $role ." " . $admin_roles[$role] . "\r\n";

        $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
        $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
        $to = $email;
        $subject = htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - vytvoření uživatele " . $username;
        $message = "$email_admin_novy_uzivatel";
        $message = str_replace("##UZIVATEL##", $UZIVATEL, $message);
        $send_email = email($from_text, $from, $to, $subject, $message);
    }
}


// MAZANI UZIVATELE  - TO-DO - ADMIN NELZE SMAZAT
if (isset($_GET['delete_user'])) {

    $stmt = $conn->prepare("
		SELECT username, firstname, lastname, email FROM site_admins
		WHERE username = ?
	 ");
    $stmt->bind_param(
        "s",
        $_GET['username']
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $line = mysqli_fetch_assoc($result);


    $stmt = $conn->prepare("
        DELETE FROM site_admins
        WHERE username = ?
	");
    $stmt->bind_param(
        "s",
        $_GET['username']
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
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Uživatel byl smazán.'
        ];
        header("Location: index.php?users");

        //pri smazani uživatele odešleme statistikovi mail
        $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
        $to = htmlspecialchars($match_data['Zavod_email_stats'], ENT_QUOTES, 'UTF-8');
        $subject = htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - smazání uživatele " . $_GET['username'];
        $message = "V administraci závodu <strong>" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . "</strong> byl smazán uživatel: " . htmlspecialchars($line['firstname'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['lastname'], ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($line['email'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $send_email = email($from_text, $from, $to, $subject, $message);
    }
}


// PRIDANI NOVEHO ZAVODNIKA
if (isset($_GET['new_shooter'])) {
    $varsymbol = substr(rand(), 0, 4);
    $alias = trim(mb_convert_case($_POST['Alias'], MB_CASE_UPPER, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER);
    $jmeno = trim(mb_convert_case($_POST['Jmeno'], MB_CASE_TITLE, "UTF-8"));
    $prijmeni = trim(mb_convert_case($_POST['Prijmeni'], MB_CASE_TITLE, "UTF-8")) . mb_convert_case($_POST['Divize_dalsi'], MB_CASE_UPPER) . $_POST['Prijmeni_stav'] . '';
    $ip = ($_SERVER["REMOTE_ADDR"] . " - admin");
    $zp = trim($_POST['ZP']);
    $email = trim($_POST['Mail']);

    empty($_POST['Divize']) ? $divize = substr($_POST['Divize_dalsi'], 1) : $divize = $_POST['Divize'];

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
            "Zpět do administrace"
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
            "Zpět do administrace"
        );
    } else {

        // konecne registrujeme zavodnika
        $stmt = $conn->prepare("
		INSERT INTO $table 
        (Alias,Prijmeni,Jmeno,ZP,VarSym,Region,Mail,Kategorie,Divize,Faktor,DatReg,RegistraceIP,Squad,Staff,ZaplatiNaMiste,Poznamka,Zavod)
        VALUES (?, ?, ?, NULLIF(?,''), ?, ?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?,''),NULLIF(?,''),?,?)
        ");
        $stmt->bind_param(
            "ssssisssssssissss",
            $alias,
            $prijmeni,
            $jmeno,
            $zp,
            $varsymbol,
            $_POST['Region'],
            $email,
            $_POST['Kategorie'],
            $divize,
            $_POST['Faktor'],
            $_POST['datreg'],
            $ip,
            $_POST['Squad'],
            $_POST['Staff'],
            $_POST['ZaplatiNaMiste'],
            $_POST['Poznamka'],
            $table
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
        }

        // nastaveni identifikatoru (klice) a datumu zaplaceni
        $stmt = $conn->prepare("
		UPDATE $table 
		SET klic = FLOOR(10 + (RAND(Cislo) * 9000))
		WHERE klic is null or klic=0
	    ");
        $stmt->execute();
        $stmt->close();

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

        $tyden = str_replace(' ', '', htmlspecialchars($match_data['Zavod_datum'], ENT_QUOTES, 'UTF-8'));
        $tyden = intval(date("W", strtotime($tyden)));
        $varsymbol_new = "$tyden" . ($line['Cislo']);

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
        $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

        // podmínky pro volbu textu v závislosti na statutu závodníka
        if ($match_data['Payment_before'] == "") {
            $message = $email_registrace_zavod_bez_platby_predem_admin;
        } elseif (($line['Staff'] == "VIP") or ($line['Staff'] == "RO") or ($line['Staff'] == "POM")) {
            $stmt = $conn->prepare("
		UPDATE $table 
		SET Zaplaceno = 'on',
        Castka = '0',
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
            $message = $email_registrace_bez_platby_text_admin_novy_zavodnik;
        } elseif ($line['ZaplatiNaMiste'] == "on") {
            $message = $email_registrace_platba_na_miste_admin_novy_zavodnik;
        } elseif ($line['Squad'] == "-2") {
            $message = $email_registrace_cekatel_text_admin_novy_zavodnik;
        } else {
            $message = $email_registrace_platba_text_admin_novy_zavodnik;
        }

        // priprava podkladu pro email zavodnikovi
        // nice názvy pro mail
        $faktorLabels = [
            "MIN" => "Minor",
            "MAJ"  => "Major"
        ];

        $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

        $squadLabels = [
            "-2" => "Čekatel",
            "100"  => "Prematch"
        ];
        $squadLabel = $squadLabels[$line['Squad']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

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
        $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
        $to = $email;
        $subject = "Registrace " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');
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
                "Závodník byl zaregistrován, pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu'>vývojáře</a> registračního systému.",
                "Zpět do administrace"
            );
        } else {
            // zapiseme do DB, ze registracni mail byl odeslan
            $stmt = $conn->prepare("
		UPDATE $table 
		SET OdeslanRegMail = '1'
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
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Závodník byl úspěšně přidán a registrační email odeslán.'
                ];
                header("refresh:0;url=index.php");
            }
        }
    }
}


// EDITACE ZAVODNIKA
if (isset($_GET['edit_shooter'])) {
    $alias = trim(mb_convert_case($_POST['Alias'], MB_CASE_UPPER, "UTF-8"));
    $jmeno = trim(mb_convert_case($_POST['Jmeno'], MB_CASE_TITLE, "UTF-8"));
    $prijmeni = trim(mb_convert_case($_POST['Prijmeni'], MB_CASE_TITLE, "UTF-8")) . $_POST['Prijmeni_stav'] . '';
    $zp = trim($_POST['ZP']);
    $email = trim($_POST['Mail']);
    $mena = $match_data['Banka_ucet_MENA'];
    $dnes = date_format(new DateTime(), "d.m.Y H:i");

    // potvrzeni vyrazeni zavodnika
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

    if ($_POST['Squad'] == "-9" && !isset($_POST['confirm_removal'])) {
        include './components/modal-confirm.php';
        ConfirmModal(
            'danger',
            'Vyřazení závodníka',
            'save.php?edit_shooter=1',
            $_POST + ['confirm_removal' => '1'],
            "Opravdu chcete vyřadit závodníka #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno']) . " " . htmlspecialchars($line['Prijmeni']) . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")?",
            "Závodník nebude odstraněn, ale přesunut do squadu VYŘAZENO (-9).",
            'Vyřadit závodníka',
            'index.php',
            'Zrušit'
        );
        exit();
    }

    if (($_POST['Staff'] == "VIP") or ($_POST['Staff'] == "RO") or ($_POST['Staff'] == "POM")) {
        $stmt = $conn->prepare("
	UPDATE $table 
		SET Alias = ?,
     Jmeno = ?,
     Prijmeni = ?,
     ZP = ?,
     Mail = ?,
     Divize = ?,
     Kategorie = ?,
     Faktor = ?,
     Region = ?,
     Squad = ?,
     Staff = ?,
     Zaplaceno = 'on',
     Castka = '0',
     Mena = ?,
     ZaplatiNaMiste = NULLIF(?,''),
     Poznamka = ?
    WHERE Cislo= ?
    ");
        $stmt->bind_param(
            "sssssssssissssi",
            $alias,
            $jmeno,
            $prijmeni,
            $zp,
            $email,
            $_POST['Divize'],
            $_POST['Kategorie'],
            $_POST['Faktor'],
            $_POST['Region'],
            $_POST['Squad'],
            $_POST['Staff'],
            $mena,
            $_POST['ZaplatiNaMiste'],
            $_POST['Poznamka'],
            $_POST['shooterID']
        );
    } else {
        $stmt = $conn->prepare("
	UPDATE $table 
		SET Alias = ?,
     Jmeno = ?,
     Prijmeni = ?,
     ZP = ?,
     Mail = ?,
     Divize = ?,
     Kategorie = ?,
     Faktor = ?,
     Region = ?,
     Squad = ?,
     Staff = ?,
     Zaplaceno = NULLIF(?,''),
     Mena = ?,
     ZaplatiNaMiste = NULLIF(?,''),
     Poznamka = ?
    WHERE Cislo= ?
    ");
        $stmt->bind_param(
            "sssssssssisssssi",
            $alias,
            $jmeno,
            $prijmeni,
            $zp,
            $email,
            $_POST['Divize'],
            $_POST['Kategorie'],
            $_POST['Faktor'],
            $_POST['Region'],
            $_POST['Squad'],
            $_POST['Staff'],
            $_POST['Zaplaceno'],
            $mena,
            $_POST['ZaplatiNaMiste'],
            $_POST['Poznamka'],
            $_POST['shooterID']
        );
    }
    $stmt->execute();
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
            'message' => 'V nastavení závodníka jste neprovedli žádné změny.'
        ];
    } else {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Změny nastavení závodníka byly úspěšně uloženy.'
        ];
    }
    $stmt->close();
    header("Location: index.php");

    // přesun čekatele do běžného squadu
    if (($_POST['Squad_old'] == "-2") and ($_POST['Squad_old'] != $_POST['Squad'])) {
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
        $squad = $line['Squad'];
        $link_cancel = "<a href='$web_adresa_admin/zrus_ucast.php?id=$line[Cislo]&klic=$line[klic]'><strong>zrušit účast</strong></a>";

        // podmínky pro volbu textu v závislosti na statutu závodníka
        if ($match_data['Payment_before'] == "") {
            $message = $email_registrace_cekatel_presun_bez_platby_predem;
        } elseif ($line['ZaplatiNaMiste'] == "on") {
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
        // nice názvy pro mail

        $STRELEC .= "<strong>IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</strong>" . "\r\n";
        $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " [$link_cancel]\r\n";
        $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
        $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
        $STRELEC .= "Squad: $squad" . "\r\n";

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
        $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
        $to = $email;
        $subject = "Změna registrace " . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8');
        $message = str_replace("##STRELEC##", $STRELEC, $message);
        $message = str_replace("##Squad##", $squad, $message);
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
                "Závodník byl zaregistrován, pro odstranění problému s odesíláním kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba odeslani emailu'>vývojáře</a> registračního systému.",
                "Zpět do administrace"
            );
        } else {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Čekatel byl přesunut do běžného squadu.'
            ];
        }
        // konec přesun čekatele do běžného squadu
    }

    // vyřazení závodníka při editaci (vyřazení je přesun do squadu -9 a ponechání v DB)
    if ($_POST['Squad'] == "-9") {
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

        $ip = ($_SERVER["REMOTE_ADDR"] . " - admin");

        $line = mysqli_fetch_array($result);

        $stmt = $conn->prepare("
        UPDATE $table
        SET SquadReg = ?,
        Vyrazeno = ?,
        VyrazenoIP = ?
        WHERE Cislo = ? AND klic = ?
        ");
        $stmt->bind_param(
            "sssii",
            $_line['Squad_old'],
            $dnes,
            $ip,
            $line['Cislo'],
            $line['klic']
        );
        $stmt->execute();
        $stmt->close();

        // příprava mailu zavodnikovi
        // nice názvy pro mail
        $faktorLabels = [
            "MIN" => "Minor",
            "MAJ"  => "Major"
        ];
        $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

        $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
        $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
        // nice názvy pro mail

        $STRELEC .= "IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
        $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";

        $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
        $from = $match_data['Zavod_email_from'];
        $to = $line['Mail'];
        $subject = "Zrušení registrace závodníka " . $match_data['Zavod'];
        $message = $email_text_vyrazeni_admin;
        $message = str_replace("##STRELEC##", $STRELEC, $message);

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
        }
    }
}


// MAZANI ZAVODNIKA
if (isset($_GET['delete_shooter'])) {
    $line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

    $stmt = $conn->prepare("
    DELETE FROM $table 
    WHERE Cislo = ? AND klic = ?
	");
    $stmt->bind_param(
        "ii",
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
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Závodník byl smazán.'
        ];
        header("refresh:0;url=index.php");
        //pri smazani zavodnika odešleme statistikovi mail
        $from = htmlspecialchars($match_data['Zavod_email_from'], ENT_QUOTES, 'UTF-8');
        $to = htmlspecialchars($match_data['Zavod_email_stats'], ENT_QUOTES, 'UTF-8');
        $subject = htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - smazání závodníka #" . $_POST['shooterID'];
        $message = "V administraci závodu <strong>" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . "</strong> byl smazán závodník: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ")." . "\r\n";
        $send_email = email($from_text, $from, $to, $subject, $message);
    }
}

// VYRAZENI ZAVODNIKA TLAČÍTKEM V ADMINISTRACI
if (isset($_GET['cancel_shooter'])) {
    $line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

    $dnes = date_format(new DateTime(), "d.m.Y H:i");
    $ip = ($_SERVER["REMOTE_ADDR"] . " - admin");

    $stmt = $conn->prepare("
		UPDATE $table 
		SET SquadReg = ?,
		Squad = '-9', 
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
        // nice názvy pro mail

        $STRELEC .= "IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
        $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";

        $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
        $from = $match_data['Zavod_email_from'];
        $to = $line['Mail'];
        $subject = "Zrušení registrace závodníka " . $match_data['Zavod'];
        $message = $email_text_vyrazeni_admin;
        $message = str_replace("##STRELEC##", $STRELEC, $message);

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
                'type' => 'danger',
                'message' => 'Závodník byl vyřazen.'
            ];
        }
    }
}


// EVIDENCE UHRADY PLATBY
if (isset($_GET['mark_paid'])) {
    $line = getShooterData($conn, $table, $_POST['shooterID'], $_POST['shooterKEY']);

    $dnes = date_format(new DateTime(), "d.m.Y H:i");

    $stmt = $conn->prepare("
    UPDATE $table 
    SET Zaplaceno = 'on',
    Castka = ?,
    Mena = ?,
    DatumZaplaceni = ?
    WHERE Cislo = ? AND klic = ?
	");
    $stmt->bind_param(
        "sssii",
        $match_data['Banka_ucet_CASTKA'],
        $match_data['Banka_ucet_MENA'],
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
            "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba aktualizace databáze [$table]'>vývojáře</a> registračního systému.",
            "Zpět do administrace"
        );
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
        // nice názvy pro mail

        $STRELEC .= "IPSC alias: " . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Střelec: #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "\r\n";
        $STRELEC .= "Divize: $nazev_divize $faktorLabel" . "\r\n";
        $STRELEC .= "Kategorie: $nazev_kategorie" . "\r\n";
        $STRELEC .= "Squad: " . $line['Squad'] . "\r\n";

        $from_text = htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8');
        $from = $match_data['Zavod_email_from'];
        $to = $line['Mail'];
        $subject = "Evidence platby " . $match_data['Zavod'];
        $message = $email_text_platba;
        $message = str_replace("##STRELEC##", $STRELEC, $message);

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
                'message' => 'Informace o platbě zaevidována.'
            ];
        }
    }
}

// NOVY SQUAD
if (isset($_GET['new_squad'])) {
    $stmt = $conn->prepare("
        INSERT INTO $table_squads 
        (Number,Name)
	    VALUES (?, ?)
	");
    $stmt->bind_param(
        "is",
        $_POST['Number'],
        $_POST['Name']
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
            'message' => 'Squad byl úspěšně přidán.'
        ];
        header("Location: index.php?squads");
    }
}

// MAZANI SQUADU  - HOTOVO REFACTORING
if (isset($_GET['delete_squad'])) {
    $stmt = $conn->prepare("
        DELETE FROM $table_squads 
        WHERE Number = ?
	");
    $stmt->bind_param(
        "i",
        $_GET['number']
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
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Squad byl smazán.'
        ];
        header("Location: index.php?squads");
    }
}

// NOVA DIVIZE
if (isset($_GET['new_division'])) {
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
            'message' => 'Divize byla úspěšně přidána'
        ];
        header("Location: index.php?divisions");
    }
}

// MAZANI DIVIZE
if (isset($_GET['delete_division'])) {
    $stmt = $conn->prepare("
        DELETE FROM $table_divisions 
        WHERE Name = ?
	");
    $stmt->bind_param(
        "s",
        $_GET['name']
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
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Divize byla smazána.'
        ];
        header("Location: index.php?divisions");
    }
}

// NOVA KATEGORIE
if (isset($_GET['new_category'])) {
    $stmt = $conn->prepare("
        INSERT INTO $table_categories 
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
            'message' => 'Kategorie byla úspěšně přidána.'
        ];
        header("Location: index.php?categories");
    }
}

// MAZANI KATEGORIE
if (isset($_GET['delete_category'])) {
    $stmt = $conn->prepare("
        DELETE FROM $table_categories 
        WHERE Name = ?
	");
    $stmt->bind_param(
        "s",
        $_GET['name']
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
    } else {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Kategorie byla smazána.'
        ];
        header("Location: index.php?categories");
    }
}

if (isset($_POST['update'])) {
    $table = $_POST['table'];
    $field = $_POST['field'];
    $id = intval($_POST['id']);
    $value = $_POST['value'];

    // Povolené tabulky a pole
    $allowedTables = [
        'site_admins' => ['username', 'email', 'role', 'firstname', 'lastname'],
        $table_squads => ['Number', 'Name'],
        $table_divisions => ['Name', 'Value'],
        $table_categories => ['Name', 'Value']
    ];

    if (array_key_exists($table, $allowedTables) && in_array($field, $allowedTables[$table])) {
        $stmt = $conn->prepare("UPDATE `$table` SET `$field` = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $id);
        $stmt->execute();
        $stmt->close();
    }
    exit;
}
?>

<script type='text/javascript'>
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    myModal.show();
</script>