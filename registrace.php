<?php
include "./header.php";

session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));

$match_data['Zavod_cas_registrace'] = $match_data['Zavod_cas_registrace'] ?? '00:00:00';
$paymentBeforeClass = empty($match_data['Payment_before']) ? 'd-none' : '';

$casRegistraceKonec = $match_data['Zavod_cas_registrace_konec'];
$casRegistraceZacatek = $match_data['Zavod_cas_registrace_zacatek'];

$zavodObcanskyPrukazRequired = !empty($match_data['Zavod_obcansky_prukaz']) ? 'required' : '';
$zavodObcanskyPrukazClass = !empty($match_data['Zavod_obcansky_prukaz']) ? '' : 'd-none';

$zavodMoreDivisionsRequired = !empty($match_data['Zavod_more_divisions']) ? 'required' : '';
$zavodMoreDivisionsClass = !empty($match_data['Zavod_more_divisions']) ? '' : 'd-none';

$dnes = new DateTime();
$datumZavod = new DateTime($match_data['Zavod_datum']);

$datumZacatekRegistrace = (clone $datumZavod)
    ->modify("-{$match_data['Zavod_zacatek_registrace']} days")
    ->setTime(...explode(':', $casRegistraceZacatek));

// vytvořit konec registrace (datum minus Y dní + čas)
$datumKonecRegistrace = (clone $datumZavod)
    ->modify("-{$match_data['Zavod_konec_registrace']} days")
    ->setTime(...explode(':', $casRegistraceKonec));

$reg_started = false;
$reg_text = "";

if ($match_data['Zavod_registrace_pozastaveno'] === "on") {
    $reg_text = "<span class='text-danger'>Registrace je pozastavená</span>";
} else if ($dnes > $datumKonecRegistrace) {
    $reg_text = "Registrace skončila " . $datumKonecRegistrace->format('j.n.Y H:i') . " ";
} else if ($dnes < $datumZacatekRegistrace) {
    $reg_text = "Registrace bude spuštěna " . $datumZacatekRegistrace->format('j.n.Y H:i') . " ";
} else {
    $reg_started = true;
    $reg_text = "Registrace bude ukončena " . $datumKonecRegistrace->format('j.n.Y H:i') . " ";
}

echo "<h2 class='pb-3'> $reg_text </h2>";

// Načtení squadů
$nazev_squadu = $cislo_squadu = [];
$excludePrematch = ($match_data['Squad_prem_max'] == 0) ? "AND Number != 100" : "";
$sql = "SELECT * FROM " . $conn->real_escape_string($table_squads) . " WHERE Number >= -2 $excludePrematch";
$result = $conn->query($sql);
while ($line = $result->fetch_assoc()) {
    $zkratkad = $line['Id'];
    $nazev_squadu[$zkratkad] = $line['Name'];
    $cislo_squadu[$zkratkad] = $line['Number'];
}

// Výpis squadů
foreach ($nazev_squadu as $zkratkad => $nazvy_squadu) {
    $zkratka = $cislo_squadu[$zkratkad] ?? '';

    // Počet závodníků
    $stmt = $conn->prepare("SELECT COUNT(*) FROM " . $table . " WHERE Squad = ?");
    $stmt->bind_param("s", $zkratka);
    $stmt->execute();
    $stmt->bind_result($pocet);
    $stmt->fetch();
    $stmt->close();

    $obsazenost = "<small> [obsazenost: " . $pocet . "/" . $match_data['Squad_main_max'] . "]</small>";
    $obsazenostProcent = round(($pocet / $match_data['Squad_main_max']) * 100);
    if ($obsazenostProcent < 50) {
        $barClass = 'bg-success';
    } elseif ($obsazenostProcent < 90) {
        $barClass = 'bg-warning';
    } else {
        $barClass = 'bg-danger';
    }
    if ($zkratka == 100) {
        echo "<h4>Prematch " . $datumPrematch->format('j.n.Y') . " ($match_data[Zavod_cas_prematch])</h4>";
    };

    if ($zkratka == 101 and (empty($match_data['Zavod_cas_main_dopoledne']) or empty($match_data['Zavod_cas_main_odpoledne']))) {
        echo "<h4>Hlavní závod " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main])</h4>";
    };
    if ($zkratka == 101 and (!empty($match_data['Zavod_cas_main_dopoledne']) and !empty($match_data['Zavod_cas_main_odpoledne']))) {
        echo "<h4>Hlavní závod - dopolední směna - " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main_dopoledne])</h4>";
    };

    if ($zkratka == 201 and !empty($match_data['Zavod_cas_main_dopoledne']) and !empty($match_data['Zavod_cas_main_odpoledne'])) {
        echo "<h4>Hlavní závod - odpolední směna - " . $datumZavod->format('j.n.Y') . " ($match_data[Zavod_cas_main_odpoledne])</h4>";
    };

    echo "<div class='row my-3 mx-1 ms-2 border border-primary bg-white clearfix'>";
?>
    <div class="progress" style="height: 4px;">
        <div class="progress-bar <?= $barClass ?>" role="progressbar"
            style="width: <?= $obsazenostProcent ?>%;"
            aria-valuenow="<?= $obsazenostProcent ?>"
            aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    <?php
    echo "<div class='caption fw-bold col h5 py-2 px-2'><span>$nazvy_squadu" . ($zkratka > 100 ? $obsazenost : '') . "</span>";

    // Stav registrace, tlacitko
    $disabledMatchBtn = "<button class='btn btn-outline-dark float-end mb-2' disabled>Pozastaveno</button>";
    $enabledBtn = "<button class='btn btn-primary float-end mb-2' data-bs-toggle='collapse' href='#reg_form_$zkratkad'>Vybrat</button>";
    $disabledBtn = "<button class='btn btn-danger float-end mb-2' disabled>Obsazeno</button>";


    if ($match_data['Zavod_registrace_pozastaveno'] == "on") {
        echo $disabledMatchBtn;
    } else if ($reg_started && $dnes < $datumKonecRegistrace) {
        echo ($pocet < $match_data['Squad_main_max']) ? $enabledBtn : $disabledBtn;
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
        if (empty($match_config['Payment_before'])) {
            $paymentStatus = "text-dark";
        }
        if ($line['Zaplaceno'] == "on") {
            $paymentStatus = "text-success";
        }
        if (($dnes >= $datumPaymentWarn)  && $line['Squad'] != "-9" && $line['Zaplaceno'] != "on" && $line['ZaplatiNaMiste'] != "on") {
            $paymentStatus = "text-danger";
        }

        // definice ikon 
        $serieIcon = "";
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

    // Registrační formulář
    echo "<div class='col bg-light m-3 border rounded border-primary'><div id='reg_form_$zkratkad' class='collapse'>";
    echo "<form class='row my-3 needs-validation' method='post' action='./save.php' novalidate>";
    echo "<input type='hidden' name='Squad' value='" . htmlspecialchars($zkratka, ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='datreg' value=" . $dnes->getTimestamp() . ">";
    echo "<input type='hidden' name='token' value=" . $_SESSION['token'] . ">";
    echo "<input type='hidden' name='gender'>";

    $result = $conn->query("SELECT Max(Cislo) FROM " . $table . "");
    $line = mysqli_fetch_row($result);

    $tyden = (clone $datumZavod)->format('W');
    $varsymbol = "$tyden" . ($line[0] + 1);
    ?>
    <div class="row">
        <div class="col-md-4">
            <label for="Alias" class="form-label mt-2">IPSC alias&nbsp;&nbsp;<a href="https://ipscresults.org/Mobile/AliasAvailability.html" target="_blank" data-bs-toggle="tooltip" title="Ověřte, zda není zadávaný alias již registrovaný."><button type="button" class="btn btn-outline-success btn-sm">Ověřit</button></a>&nbsp;&nbsp;<a href="https://ipscresults.org/Mobile/AliasRegistration.html" target="_blank" data-bs-toggle="tooltip" title="Pokud ještě nemáte alias, zaregistrujte si jej."><button type="button" class="btn btn-outline-primary btn-sm">Vytvořit</button></a></label>
            <input pattern=".{3,16}" class="form-control" type="text" name="Alias" id="Alias<?= $zkratka ?>" placeholder="3-16 znaků, diakritiky a spec. znaků" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="replaceChars(<?= $zkratka ?>) " required>
            <div class="invalid-feedback">Nevyplnili jste IPSC alias nebo má neplatnou délku (3-16 znaků)</div>
            <label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
        </div>
        <div class="col-md-3 <?= $zavodObcanskyPrukazClass ?>">
            <label for="ObcanskyPrukaz" class="form-label mt-3">Číslo OP / EZP
                <a
                    href="#"
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
            <input class="form-control" type="text" name="ObcanskyPrukaz" id="ObcanskyPrukaz<?= $zkratka ?>" placeholder="0123456789" onfocus="this.placeholder = ''" onblur="this.placeholder = '0123456789'" <?= $zavodObcanskyPrukazRequired ?>>
            <div class="invalid-feedback">Nevyplnili jste číslo OP / EZP<br>(u juniora bez OP napište 0000000000)</div>
        </div>
        <div class="col-md-3 mt-5 <?= $zavodObcanskyPrukazClass ?>">
            <label class="form-check-label" for="ZbrojniOpravneni<?= $zkratka ?>">
                <input class="me-1" type="checkbox" class="form-check-input" id="ZbrojniOpravneni<?= $zkratka ?>" name="ZbrojniOpravneni"> Držitel zbrojního oprávnění
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <label for="Jmeno" class="form-label mt-3">Jméno</label>
            <input class="form-control" type="text" name="Jmeno" id="Jmeno<?= $zkratka ?>" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan';replaceChars('<?= $zkratka ?>')" required>
            <div class="invalid-feedback">Nevyplnili jste jméno</div>
        </div>
        <div class="col-md-3">
            <label class="form-label mt-3">Příjmení</label>
            <input class="form-control" type="text" name="Prijmeni" id="Prijmeni<?= $zkratka ?>" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" placeholder="Novák" onblur="this.placeholder = 'Novák';replaceChars('<?= $zkratka ?>')" required>
            <div class="invalid-feedback">Nevyplnili jste příjmení</div>
        </div>
        <div class="col-md-2">
            <label class="form-label mt-3">Doplnění jména</label>
            <select class="form-select" name="Prijmeni_stav" id="Prijmeni_stav<?= $zkratka ?>">
                <option value="" selected>-</option>
                <option value=" ml.">ml.</option>
                <option value=" st.">st.</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="Email" class="form-label mt-3">Email</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input class="form-control" type="email" id="Email<?= $zkratka ?>" name="Email" onfocus="this.placeholder = ''" onkeypress="return avoidspace(event)" placeholder="novak@mujemail.cz" onblur="replaceChars('<?= $zkratka ?>')" required>
            </div>
            <div class="invalid-feedback">Nevyplnili jste email</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label for="Kategorie" class="form-label mt-3">Kategorie</label>
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
            <label for="divize" class="form-label mt-3">Divize</label>
            <select class="form-select" name="Divize" id="Divize<?= $zkratka ?>" onchange="toggleDivizeMain(<?= $zkratka ?>)" <?= $zavodMoreDivisionsRequired ?>>
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
        <div class="col-md-2 <?= $zavodMoreDivisionsClass ?>">
            <label for="divize_dalsi" class="form-label mt-3 mb-1 text-danger">
                Další divize <a
                    href="#"
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
            <select class="form-select" name="Divize_dalsi" id="Divize_dalsi<?= $zkratka ?>" onchange="toggleDivize(<?= $zkratka ?>)" <?= $zavodMoreDivisionsRequired ?>>
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
            <label for="Faktor" class="form-label mt-3">Faktor</label>
            <select class="form-select" name="Faktor" id="Faktor<?= $zkratka ?>" required>
                <option value="" selected>--- vyberte ---</option>
                <option value="MIN">Minor</option>
                <option value="MAJ">Major</option>
            </select>
            <div class="invalid-feedback">Nevybrali jste faktor</div>
        </div>
        <div class="col-md-2">
            <label for="Region" class="form-label mt-3">Region</label>
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
            <label for="Staff" class="form-label mt-3">Staff</label>
            <select class="form-select" name=Staff>
                <option value="PAY" selected>Platící závodník</option>
                <option value="RO">Rozhodčí</option>
                <option value="POM">Pomocník</option>
            </select>
        </div>
    </div>
    <div class="col-12 mt-4 text-start">
        Provedením registrace vyjadřuji souhlas s
        <a data-bs-toggle="collapse" href="#collapseRules" role="button" aria-expanded="false" aria-controls="collapseRules">pravidly registrace</a> a&nbsp;zpracováním osobních údajů.
        <div class="collapse" id="collapseRules">
            <div class="card card-body mt-2 mb-3 me-4">
                <ul>
                    <li>V souladu s pravidlem 6.6.2 je účast v prematchi omezena na organizátory, rozhodčí, pomocníky a sponzory.</li>
                    <li>Rozhodčí se registrují po dohodě s RM.</li>
                    <li>Registrace se uzavírá <?= $match_data['Zavod_konec_registrace']; ?> dny před konáním hlavního závodu (<?= $datumKonecRegistrace->format('j.n.Y') ?>).</li>
                    <li>Pořadatelé si vyhrazují právo dodatečně měnit zařazení závodníků do squadů dle potřeb hladkého průběhu závodu.</li>
                    <li>Změny v registraci (např. náhrada závodníka při přenosu startovného) lze provést nejpozději v den prematche (<?= $datumPrematch->format('j.n.Y') ?>).</li>
                    <li>Přesuny závodníků mezi squady na základě jejich žádosti lze provést <b>nejpozději do 30 minut před oficiálním zahájením hlavního závodu.</b></li>
                    <li class="text-danger fw-bold">Protože jsou podklady pro zaplacení startovaného posílány emailem, zbavuje se závodník při zadání neplatné emailové adresy možnosti zúčastnit se závodu. Rovněž nebude moci být informován o případných změnách.</li>
                    <li class="<?= $paymentBeforeClass ?>">Startovné se hradí tak, aby platba proběhla do <?= $match_data['Zavod_pocet_dni_na_platbu'] ?> dnů od registrace.<br>- u závodníků zaregistrovaných méně jak <?= $match_data['Zavod_pocet_dni_na_platbu'] ?> dní před závodem je třeba startovné zaplatit <strong>nejpozději jeden den před prematchem</strong> (<?= $datumPrematch->modify("-1 days")->format('j.n.Y') ?>)</li>
                    <li class="<?= $paymentBeforeClass ?>">V případě neuhrazení startovného v řádném termínu je registrace zrušena.<br>- neplatí pro organizátory, pomocníky a rozhodčí.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" name="registrovat" class="btn btn-primary mt-2">Registrovat</button>
    </div>
<?php
    echo "</form></div></div></div>";
}
?>
<pre>
- rozhodčí <i class='far fa-clock' style='font-size:14px'></i>
- pomocník <i class='far fa-handshake' style='font-size:14px'></i>
- VIP <i class='far fa-crown' style='font-size:12px'></i>
<span class="<?= $paymentBeforeClass ?> text-success">- zaplaceno nebo potvrzeno pořadatelem (pomocníci a rozhodčí)</span>
<span class="<?= $paymentBeforeClass ?> text-danger">- zbývá méně jak 5 dní do zaplacení</span>
</pre>

<script type="text/javascript" src="./js/reg_form.js"></script>
<?php include "./footer.php"; ?>