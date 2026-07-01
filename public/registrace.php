<?php
include "./header.php";
$_SESSION['token'] = bin2hex(random_bytes(32));

$casRegistraceKonec = $match_data['Zavod_cas_registrace_konec'];
$casRegistraceZacatek = $match_data['Zavod_cas_registrace_zacatek'];

$dnes = new DateTime();

$datumZavod = new DateTime($match_data['Zavod_datum']);

$datumZacatekRegistrace = (clone $datumZavod)
    ->modify("-{$match_data['Zavod_zacatek_registrace']} days")
    ->setTime(...explode(':', $casRegistraceZacatek));

$datumKonecRegistrace = (clone $datumZavod)
    ->modify("-{$match_data['Zavod_konec_registrace']} days")
    ->setTime(...explode(':', $casRegistraceKonec));

$reg_started = false;
$reg_text = "";

if ($match_data['Zavod_registrace_pozastaveno'] == 1) {
    $reg_text = "<span class='text-danger'>Registrace je pozastavená</span>";
} else if ($dnes > $datumKonecRegistrace) {
    $reg_text = "Registrace skončila " . $datumKonecRegistrace->format('j.n.Y H:i') . " ";
} else if ($dnes < $datumZacatekRegistrace) {
    $reg_text = "Registrace bude spuštěna " . $datumZacatekRegistrace->format('j.n.Y H:i') . " ";
} else {
    $reg_started = true;
    $reg_text = "Registrace bude ukončena " . $datumKonecRegistrace->format('j.n.Y H:i') . " ";
}

// Příznak: je registrace aktivní?
$regAktivni = $reg_started
    && $dnes < $datumKonecRegistrace
    && $match_data['Zavod_registrace_pozastaveno'] == 0;
?>

<h2 class='pb-3'>
    <?= $reg_text ?>
</h2>

<?php
// Načtení squadů
$nazev_squadu = $cislo_squadu = [];
$excludePrematch = ($match_data['Squad_prem_max'] == 0) ? "AND Number != 100" : "";
$sql = "SELECT * FROM " . $conn->real_escape_string($table_squads) . " WHERE Number >= -2 $excludePrematch ORDER BY Id";
$result = $conn->query($sql);
while ($line = $result->fetch_assoc()) {
    $zkratkad = $line['Id'];
    $nazev_squadu[$zkratkad] = $line['Name'];
    $cislo_squadu[$zkratkad] = $line['Number'];
}

// Načteme počty všech squadů
$counts = [];
$sqlCounts = "SELECT Squad, COUNT(*) AS count FROM " . $table . " GROUP BY Squad";
$resCounts = $conn->query($sqlCounts);
while ($r = $resCounts->fetch_assoc()) {
    $counts[(int)$r['Squad']] = (int)$r['count'];
}
$resCounts->free();

// Získáme kapacity squadů z nastavení závodu
$squadMainMax = (int)($match_data['Squad_main_max'] ?? 0);
$squadPremMax = (int)($match_data['Squad_prem_max'] ?? 0);

// Výpis squadů
foreach ($nazev_squadu as $zkratkad => $nazvy_squadu) {
    $zkratka = (int)($cislo_squadu[$zkratkad] ?? 0);
    $pocet = $counts[$zkratka] ?? 0;

    if ($zkratka === -2) {
        $maxCapacity = null; // neomezeno
    } elseif ($zkratka === 100) {
        $maxCapacity = ($squadPremMax > 0) ? $squadPremMax : $squadMainMax;
    } else {
        $maxCapacity = $squadMainMax;
    }

    if ($maxCapacity === null) {
        $obsazenost = "<small> [obsazenost: $pocet / neomezeno]</small>";
        $obsazenostProcent = null;
    } else {
        $obsazenost = "<small> [obsazenost: $pocet/" . $maxCapacity . "]</small>";
        $obsazenostProcent = ($maxCapacity > 0) ? round(($pocet / $maxCapacity) * 100) : 0;
        $obsazenostProcent = max(0, min(100, $obsazenostProcent));
    }

    // Barva (pouze pokud máme procenta)
    if ($obsazenostProcent === null) {
        $barClass = 'bg-success';
    } else {
        if ($obsazenostProcent < 50) $barClass = 'bg-success';
        elseif ($obsazenostProcent < 90) $barClass = 'bg-warning';
        else $barClass = 'bg-danger';
    }


    // Nadpisy pro prematch / hlavní závod (ponecháno)
    if ($zkratka == 100) {
        echo "<h4>Prematch " . $datumPrematch->format('j.n.Y') . " ($match_data[Zavod_cas_prematch])</h4>";
    }

    if ($zkratka == 101 and (empty($match_data['Zavod_cas_main_dopoledne']) or empty($match_data['Zavod_cas_main_odpoledne']))) {
        echo "<h4>Hlavní závod " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main])</h4>";
    }
    if ($zkratka == 101 and (!empty($match_data['Zavod_cas_main_dopoledne']) and !empty($match_data['Zavod_cas_main_odpoledne']))) {
        echo "<h4>Hlavní závod - dopolední směna - " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main_dopoledne])</h4>";
    }
    if ($zkratka == 201 and !empty($match_data['Zavod_cas_main_dopoledne']) and !empty($match_data['Zavod_cas_main_odpoledne'])) {
        echo "<h4>Hlavní závod - odpolední směna - " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main_odpoledne])</h4>";
    }

    echo "<div class='row my-3 mx-1 ms-2 border border-primary bg-white clearfix'>";

    // Progress bar: pokud je neomezeno, nic nevypisujeme
    if ($obsazenostProcent !== null) {
        echo '<div class="progress" style="height:4px;">';
        echo '<div class="progress-bar ' . $barClass . '" role="progressbar" style="width:' . $obsazenostProcent . '%;" aria-valuenow="' . $obsazenostProcent . '" aria-valuemin="0" aria-valuemax="100"></div>';
        echo '</div>';
    }

    echo "<div class='caption fw-bold col h5 py-2 px-2'><span>$nazvy_squadu" . ($zkratka > 100 ? $obsazenost : ($zkratka <= 100 ? $obsazenost : '')) . "</span>";

    // Stav registrace, tlačítko
    $disabledMatchBtn = "<button class='btn btn-outline-dark float-end mb-2' disabled>Pozastaveno</button>";
    $enabledBtn = "<button class='btn btn-primary float-end mb-2' data-bs-toggle='collapse' href='#reg_form_$zkratkad'>Vybrat</button>";
    $disabledBtn = "<button class='btn btn-danger float-end mb-2' disabled>Obsazeno</button>";

    if ($regAktivni) {
        if ($maxCapacity === null) {
            echo $enabledBtn;
        } else {
            echo ($pocet < $maxCapacity) ? $enabledBtn : $disabledBtn;
        }
    } elseif (!$regAktivni) {
        echo "";
    } else {
        echo $disabledMatchBtn;
    }

    echo "</div>";
    echo "<div class='col-12 d-block pb-3 text-start'>";

    // Výpis závodníků
    $stmt = $conn->prepare("SELECT Alias,Prijmeni,Jmeno,Zaplaceno,DatumZaplaceni,ZaplatiNaMiste,DatPay,Divize,Faktor,Staff,Squad,Urgence FROM " . $table . " WHERE Squad = ? ORDER BY Zaplaceno DESC, Prijmeni");
    $stmt->bind_param("s", $zkratka);
    $stmt->execute();
    $result_names = $stmt->get_result();
    while ($line = $result_names->fetch_assoc()) {
        $datumZaplatit = new DateTime($line['DatPay']);
        $datumPaymentWarn = (clone $datumZaplatit)->modify("-5 days");

        // zvyrazneni statutu zavodniku (placeno, neplaceno...) 
        $paymentStatus = "";

        if ($line['Zaplaceno'] == 1 && $match_data['Payment_before'] != 0) {
            $paymentStatus = "text-success";
        } else if ($match_data['Payment_before'] == 0 || $line['Squad'] == -2 || $line['ZaplatiNaMiste'] == 1) {
            $paymentStatus = "text-dark";
        } else if (($dnes >= $datumPaymentWarn) && ($line['Zaplaceno'] == 0 || $line['ZaplatiNaMiste'] == 0)) {
            $paymentStatus = "text-danger";
        }

        // definice ikon 
        $serieIcon = ""; //doprogramovat podle potřeby, zatím ponecháno prázdné, protože se nevyužívá
        $staffIcon = "";
        if ($line['Staff'] == "RO") {
            $staffIcon = "<i class='far fa-clock' style='font-size:12px'></i>";
        };
        $pomIcon = "";
        if ($line['Staff'] == "POM") {
            $staffIcon = "<i class='far fa-handshake' style='font-size:12px'></i>";
        };
        $vipIcon = "";
        if ($line['Staff'] == "VIP") {
            $staffIcon = "<i class='far fa-crown' style='font-size:12px'></i>";
        };
        $faktor = ($line['Faktor'] == "MAJ") ? "+" : '';

        echo "<span class='fw-bold text-nowrap $paymentStatus'>" . $serieIcon . $staffIcon  . "&nbsp;" . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "</span>&nbsp;<small class='text-nowrap'>(" . htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8') . $faktor . ")</small>, ";
    }
    $stmt->close();
    echo "</div>";

    // REGISTRACNI FORMULAR
    echo "<div class='col bg-light m-3 border rounded border-primary'><div id='reg_form_$zkratkad' class='collapse'>";
    echo "<form class='row my-3 needs-validation' method='post' action='./save.php' novalidate>";
    echo "<input type='hidden' name='action' value='register_shooter'>";
    echo "<input type='hidden' name='Squad' value='" . htmlspecialchars($zkratka, ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='token' value=" . $_SESSION['token'] . ">";
    echo "<input type='hidden' name='gender'>";

    $result = $conn->query("SELECT Max(Cislo) FROM " . $table . "");
    $line = mysqli_fetch_row($result);

    $tyden = (clone $datumZavod)->format('W');
    $varsymbol = "$tyden" . ($line[0] + 1);
?>
    <div class="row">
        <div class="col-md-3">
            <label for="Alias" class="form-label mt-2">IPSC alias&nbsp;&nbsp;<a href="https://ipscresults.org/Mobile/AliasAvailability.html" target="_blank" data-bs-toggle="tooltip" title="Ověřte, zda není zadávaný alias již registrovaný."><button type="button" class="btn btn-outline-success btn-sm">Ověřit</button></a>&nbsp;&nbsp;<a href="https://ipscresults.org/Mobile/AliasRegistration.html" target="_blank" data-bs-toggle="tooltip" title="Pokud ještě nemáte alias, zaregistrujte si jej."><button type="button" class="btn btn-outline-primary btn-sm">Vytvořit</button></a></label>
            <input
                pattern=".{3,16}"
                class="form-control"
                type="text" name="Alias"
                id="Alias<?= $zkratka ?>"
                placeholder="3-16 znaků, diakritiky a spec. znaků"
                onkeypress="return avoidspace(event)"
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = '3-16 znaků, diakritiky a spec. znaků';replaceChars('<?= $zkratka ?>')"
                required>
            <div class="invalid-feedback">Nevyplnili jste IPSC alias nebo má neplatnou délku (3-16 znaků)</div>
            <label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
        </div>
        <div class="col-md-3 <?= hidden($match_data['Zavod_obcansky_prukaz'] == 0); ?>">
            <label for="ObcanskyPrukaz" class="form-label mt-3">Číslo OP / EZP
                <a
                    role="button"
                    tabindex="0"
                    id="userInfoBtn"
                    data-bs-toggle="popover"
                    data-bs-placement="top"
                    data-bs-html="true"
                    data-bs-title="Občanský průkaz a Evrovský zbrojní pas"
                    data-bs-content="Nemá-li závodník dosud vydaný občanský průkaz<br>(nejčastěji kategorie Junior), napište <strong>0000000000</strong>.<br><br>U cizích státních příslušníků vyplňte číslo identifikačního <br>průkazu i v případě, že obsahuje mezery nebo písmena.">
                    <sup><i class="fas fa-question-circle text-primary ms-1"></i></sup>
                </a>
            </label>
            <input
                class="form-control"
                type="text"
                name="ObcanskyPrukaz"
                id="ObcanskyPrukaz<?= $zkratka ?>"
                placeholder="0123456789"
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = '0123456789';replaceChars('<?= $zkratka ?>')"
                <?= required($match_data['Zavod_obcansky_prukaz'] == 1); ?>>
            <div class="invalid-feedback">Nevyplnili jste číslo OP / EZP</div>
        </div>
        <div class="col-md-3 mt-5 <?= hidden($match_data['Zavod_obcansky_prukaz'] == 0); ?>">
            <label class="form-check-label" for="ZbrojniOpravneni<?= $zkratka ?>">
                <input
                    class="me-1"
                    type="checkbox"
                    class="form-check-input"
                    id="ZbrojniOpravneni<?= $zkratka ?>"
                    name="ZbrojniOpravneni">
                Držitel zbrojního oprávnění
            </label>
        </div>
        <div class="col-md-3 <?= hidden($match_data['Zavod_cislo_zbrane'] == 0); ?>">
            <label for="CZ" class="form-label mt-3">Číslo zbraně</label>
            <input
                class="form-control"
                type="text"
                name="CZ"
                id="CZ<?= $zkratka ?>"
                placeholder="ZF-1"
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'ZF-1';replaceChars('<?= $zkratka ?>')"
                <?= required($match_data['Zavod_cislo_zbrane'] == 1); ?>>
            <div class="invalid-feedback">Nevyplnili jste číslo zbraně</div>
        </div>

    </div>

    <div class="row mt-2">
        <div class="col-md-3">
            <label for="Jmeno" class="form-label">Jméno</label>
            <input
                class="form-control"
                type="text"
                name="Jmeno"
                id="Jmeno<?= $zkratka ?>"
                onkeypress="return avoidspace(event)"
                placeholder="Jan" onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'Jan';replaceChars('<?= $zkratka ?>')"
                required>
            <div class="invalid-feedback">Nevyplnili jste jméno</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">Příjmení</label>
            <input
                class="form-control"
                type="text"
                name="Prijmeni"
                id="Prijmeni<?= $zkratka ?>"
                onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''"
                placeholder="Novák"
                onblur="this.placeholder = 'Novák';replaceChars('<?= $zkratka ?>')"
                required>
            <div class="invalid-feedback">Nevyplnili jste příjmení</div>
        </div>
        <div class="col-md-2">
            <label class="form-label">Doplnění jména</label>
            <select class="form-select" name="Prijmeni_stav" id="Prijmeni_stav<?= $zkratka ?>">
                <option value="" selected>-</option>
                <option value=" ml.">ml.</option>
                <option value=" st.">st.</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="Email" class="form-label">Email</label>
            <input
                class="form-control"
                type="email"
                id="Email<?= $zkratka ?>"
                name="Email"
                onfocus="this.placeholder = ''"
                onkeypress="return avoidspace(event)"
                placeholder="novak@mujemail.cz"
                onblur="this.placeholder = 'novak@mujemail.cz';replaceChars('<?= $zkratka ?>')"
                required>
            <div class="invalid-feedback">Nevyplnili jste email</div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-2">
            <label for="Kategorie" class="form-label">Kategorie</label>
            <select class="form-select" name="Kategorie" id="Kategorie<?= $zkratka ?>" required>
                <option value="" selected>--- vyberte ---</option>
                <?php
                $stmt = $conn->prepare("SELECT * from $table_categories");
                $stmt->execute();
                $result_names = $stmt->get_result();
                while ($line = $result_names->fetch_array()) {
                    echo "<option value=" . $line['Name'] . ">" . $line['Value'] . "</option>";
                }
                $stmt->close();
                ?>
            </select>
            <div class="invalid-feedback">Nevybrali jste kategorii</div>
        </div>
        <div class="col-md-2">
            <label for="divize" class="form-label">Divize</label>
            <select class="form-select" name="Divize" id="Divize<?= $zkratka ?>" onchange="toggleDivizeMain(<?= $zkratka ?>)" <?= required($match_data['Zavod_more_divisions'] == 1); ?>>
                <option value="" selected>--- vyberte ---</option>
                <?php
                $stmt = $conn->prepare("SELECT * from $table_divisions");
                $stmt->execute();
                $result_names = $stmt->get_result();
                while ($line = $result_names->fetch_array()) {
                    echo "<option value=" . $line['Name'] . ">" . $line['Value'] . "</option>";
                }
                $stmt->close();
                ?>
            </select>
            <div class="invalid-feedback">Nevybrali jste divizi</div>
        </div>
        <div class="col-md-2 <?= hidden($match_data['Zavod_more_divisions'] == 0); ?>">
            <label for="divize_dalsi" class="form-label mb-1 text-danger">
                Další divize <a
                    role="button"
                    tabindex="0"
                    id="userInfoBtn"
                    data-bs-toggle="popover"
                    data-bs-placement="top"
                    data-bs-html="true"
                    data-bs-title="Registrace do více divizí"
                    data-bs-content="
                        Střílíte-li v závodě ve více divizích, postupujte tímto způsobem:
                        <ul>
                            <li>Při první registaci použijte první seznam divizí.</li>
                            <li>Po dokončení registrace vyberte squad a vyplňte stejné údaje <br>(IPSC alias, Jméno, Příjmení, Email, Kategorie, Region).</li>
                            <li>Další DIVIZI vyberte ze seznamu 'Další divize'</li>
                        </ul>
                        <i>(jakmile se vybere jedna divize, není možné použít druhý seznam divizí)</i>
                    ">
                    <sup><i class="fas fa-question-circle text-primary ms-1"></i></sup>
                </a>
            </label>
            <select class="form-select" name="Divize_dalsi" id="Divize_dalsi<?= $zkratka ?>" onchange="toggleDivize(<?= $zkratka ?>)" <?= required($match_data['Zavod_more_divisions'] == 1); ?>>
                <option value="" selected>--- vyberte ---</option>
                <?php
                $stmt = $conn->prepare("SELECT * from $table_divisions");
                $stmt->execute();
                $result_names = $stmt->get_result();
                while ($line = $result_names->fetch_array()) {
                    echo "<option value=" . '-' . $line['Name'] . ">" . $line['Value'] . "</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="Faktor" class="form-label">Faktor</label>
            <select class="form-select" name="Faktor" id="Faktor<?= $zkratka ?>" required>
                <option value="" selected>--- vyberte ---</option>
                <option value="MIN">Minor</option>
                <option value="MAJ">Major</option>
            </select>
            <div class="invalid-feedback">Nevybrali jste faktor</div>
        </div>
        <div class="col-md-2">
            <label for="Region" class="form-label">Region</label>
            <select class="form-select" name="Region" id="Region<?= $zkratka ?>" required>
                <option value="AUS">Austria</option>
                <option value="CZE" selected>Czech Republic</option>
                <option value="GER">Germany</option>
                <option value="POL">Poland</option>
                <option value="SUI">Switzerland</option>
                <option value="SVK">Slovak Republic</option>
            </select>
            <div class="invalid-feedback">Nevybrali jste region</div>
        </div>
        <div class="col-md-2">
            <label for="Staff" class="form-label">Staff</label>
            <select class="form-select" name=Staff>
                <option value="PAY" selected>Platící závodník</option>
                <option value="RO">Rozhodčí</option>
                <option value="POM">Pomocník</option>
            </select>
        </div>
    </div>

    <div class="row  mt-4">
        <div class="col-md-12">
            <label for="Poznamka" class="form-label">Poznámka</label>
            <textarea
                class="form-control"
                type="text"
                name="Poznamka"
                id="Poznamka"
                placeholder="Poznámka"
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'Poznámka'"
                rows="3"></textarea>
        </div>
    </div>

    <div class="row px-4 mt-3">
        <div class="alert alert-danger m-lg-2 <?= hidden($match_data['Zavod_cislo_zbrane'] == 0); ?>" role="alert">
            Při prezenci se eviduje také VÝROBNÍ ČÍSLO ZBRANĚ. Můžete ho vyplnit zde ve formuláři nebo si jej přineste s sebou<small>(napsané na papíru, vytisknutý výpis ze zbrojního listu nebo online v Portálu občana).</small>
        </div>
        <div class="alert alert-info m-lg-2" role="alert">
            Pokud sdílíte zbraň s jiným závodníkem, napište do poznámky jeho jméno a příjmení.
        </div>
    </div>

    <div class="row px-4 mt-3">
        <div class="col-12 text-center">
            Provedením registrace vyjadřuji souhlas s
            <a data-bs-toggle="collapse" href="#collapseRules" role="button" aria-expanded="false"
                aria-controls="collapseRules">pravidly registrace</a> a&nbsp;zpracováním osobních údajů.
            <div class="collapse text-start" id="collapseRules">
                <div class="card card-body mt-2 mb-3 me-4">
                    <ul>
                        <li>Registrace se uzavírá
                            <?= ($match_data['Zavod_konec_registrace'] == 0) ? 'o půlnoci před registrací' : "$match_data[Zavod_konec_registrace] den/dny před konáním závodu" ?>.
                        </li>
                        <li>Pořadatelé si vyhrazují právo zařadit závodníků do jednotlivých směn za účelem zajištění hladkého
                            průběhu závodu.</li>
                        <li>Nezadá-li závodník při registraci platný email, vystavuje se riziku, že nebude informován o
                            případných změnách závodu.</li>
                        <li class="<?= hidden($match_data['Payment_before'] == 0); ?> ">Startovné se hradí tak, aby platba proběhla do
                            <?php echo $match_data['Zavod_pocet_dni_na_platbu']; ?> dnů od registrace.<br>- u závodníků
                            zaregistrovaných méně jak <?php echo $match_data['Zavod_pocet_dni_na_platbu']; ?> dní před závodem
                            je třeba startovné zaplatit nejpozději dva dny před závodem
                        </li>
                        <li class="<?= hidden($match_data['Payment_before'] == 0); ?>">Startovné je nevratné, lze jej přenést na jiného závodníka.</li>
                        <li class="<?= hidden($match_data['Payment_before'] == 0); ?>">V případě neuhrazení startovného v řádném termínu je registrace
                            zrušena.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary mb-2">Registrovat</button>
    </div>

<?php
    echo "</form></div></div></div>";
}
?>
<pre>
- rozhodčí <i class='far fa-clock' style='font-size:14px'></i>
- pomocník <i class='far fa-handshake' style='font-size:14px'></i>
- VIP <i class='far fa-crown' style='font-size:12px'></i>
<span class="<?= hidden($match_data['Payment_before'] == 0); ?> text-success">- zaplaceno nebo potvrzeno pořadatelem (pomocníci a rozhodčí)</span>
<span class="<?= hidden($match_data['Payment_before'] == 0); ?> text-danger">- zbývá méně jak 5 dní do zaplacení</span>
</pre>

<script type="text/javascript" src="./js/reg_form.js"></script>

<?php
include "./footer.php";
?>