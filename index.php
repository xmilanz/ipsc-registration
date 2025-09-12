<?php

declare(strict_types=1);
include "header.php";

$platba_na_miste = empty($match_data['Payment_before']) ? '<strong>(úhrada na místě)</strong>' : '';

// Pozastavení registrace
if (($match_data['Zavod_registrace_pozastaveno'] ?? '') === "on") {
    $match_data = array_merge($match_data, [
        'Squad_main_max' => '',
        'Squad_prem_max' => '',
        'zavod_categories' => '-',
        'Zavod_datum' => '-',
        'Zavod_min_pocet_ran' => '-',
        'Banka_ucet_CASTKA' => '-'
    ]);
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Základní informace</h3>
            </div>
            <dl class="row  text-start">
                <dt class="col-4 text-end text-start pe-0">Název závodu:</dt>
                <dd class="col-8 ps-2 fw-bold text-uppercase"><?= htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') ?></dd>
                <dt class="col-4 text-end text-start pe-0">Datum:</dt>
                <dd class="col-8 ps-2"><?= htmlspecialchars($match_data['Zavod_datum'], ENT_QUOTES, 'UTF-8') ?></dd>
                <dt class="col-4 text-end pe-0">Obtížnost:</dt>
                <dd class="col-8 ps-2">IPSC Level I.</dd>
                <dt class="col-4 text-end pe-0">Počet situací:</dt>
                <dd class="col-8 ps-2"><?= $match_data['Zavod_stages'] ?></dd>
                <dt class="col-4 text-end pe-0">Min. počet ran:</dt>
                <dd class="col-8 ps-2"><?= $match_data['Zavod_min_pocet_ran'] ?></dd>
                <dt class="col-4 text-end pe-0 <?php if ($match_data['Squad_prem_max'] == '0') echo "d-none"; ?>">Prematch:</dt>
                <dd class="col-8 ps-2 <?php if ($match_data['Squad_prem_max'] == '0') echo "d-none"; ?>"><?= $match_data['Squad_prem_max'] ?> závodníků</dd>
                <dt class="col-4 text-end pe-0">Hlavní závod:</dt>
                <dd class="col-8 ps-2"><?= $match_data['Zavod_stages'] * $match_data['Squad_main_max'] ?> závodníků</dd>
                <dt class="col-4 text-end text-start pe-0 <?= $registracePozastavena ?>">Stav:</dt>
                <dd class="col-8 ps-2 text-danger <?= $registracePozastavena ?> ">Pozastavená registrace</dd>
                <dt class="col-4 text-end text-start pe-0">Pořadatel:</dt>
                <dd class="col-8 ps-2"><?= htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8') ?></dd>
                <dt class="col-4 text-end text-start pe-0">Místo:</dt>
                <dd class="col-8 ps-2"><?= htmlspecialchars($match_data['Zavod_misto'], ENT_QUOTES, 'UTF-8'); ?>&nbsp;&nbsp;<a href='<?= htmlspecialchars($match_data['Zavod_misto_mapa'], ENT_QUOTES, 'UTF-8'); ?>' target='_blank' rel='noopener'><i class='fas fa-crosshairs text-dark'></i></a></dd>
                <dt class="col-4 text-end text-start pe-0">Startovné:</dt>
                <dd class="col-8 ps-2"><?= ($match_data['Banka_ucet_CASTKA'] == 0 ? 'dle propozic ' . $platba_na_miste : $match_data['Banka_ucet_CASTKA'] . ' ' . $match_data['Banka_ucet_MENA'] . ' ' . $platba_na_miste); ?></dd>
            </dl>
        </div>
    </div>

    <div class="col-md-6">
        <div class="article pb-1 mb-4 <?php if ($match_data['Zavod_zobrazovat_sponzory'] == "") echo "d-none"; ?>">
            <div class="caption mb-2 p-2 ">
                <h3>Sponzoři závodu</h3>
            </div>
            <?= $sponzor ?>
        </div>

        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Bezpečnost</h3>
            </div>
            <ol class="text-danger pe-2 text-start">
                <li>Jakákoliv manipulace se zbraní mimo stanoviště je zakázaná.</li>
                <li>zbraň musí být v pouzdru / v zavazadle / vybitá se spuštěným kohoutem.</li>
                <li>Střelec smí vyjmout zbraň z pouzdra pouze na stanovišti na na povel rozhodčího nebo na místě k tomu účelu speciálně určeném = BEZPEČNOSTNÍ ZÓNA. V bezpečnostní zóně je zakázaná manipulace se střelivem.</li>
            </ol>
            <p class="text-center fw-bold text-danger pb-2">Jakékoliv porušení zásad bezpečnosti znamená okamžitou DISKVALIFIKACI!!!</p>
        </div>
    </div>
</div>

<div class="row my-3">
    <div class="col-md-6">
        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Vedení závodu</h3>
            </div>
            <dl class="row  text-start">
                <dt class="col-4 text-end text-start pe-0">Match director:</dt>
                <dd class="col-8 ps-2"><?= htmlspecialchars($match_data['Zavod_match_director'], ENT_QUOTES, 'UTF-8') ?></dd>

                <?php if (!empty($match_data['Zavod_email_poradatel'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Email:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_email_poradatel'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_telefon_poradatel'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Telefon:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_telefon_poradatel'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <dt class="col-4 text-end text-start pe-0">Range master:</dt>
                <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_range_master'], ENT_QUOTES, 'UTF-8') ?></dd>

                <?php if (!empty($match_data['Zavod_email_range_master'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Email:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_email_range_master'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_telefon_range_master'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Telefon:</dt>
                    <dd class="col-6 ps-2"><?= $match_data['Zavod_telefon_range_master']; ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_stats'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Statistik:</dt>
                    <dd class="col-6 ps-2 "><?= htmlspecialchars($match_data['Zavod_stats'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_email_stats'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Email:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_email_stats'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_telefon_stats'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Telefon:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_telefon_stats'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_hospodar'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Hospodář:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_hospodar'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_email_hospodar'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Email:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_email_hospodar'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>

                <?php if (!empty($match_data['Zavod_telefon_hospodar'])): ?>
                    <dt class="col-4 text-end text-start pe-0">Telefon:</dt>
                    <dd class="col-6 ps-2"><?= htmlspecialchars($match_data['Zavod_telefon_hospodar'], ENT_QUOTES, 'UTF-8') ?></dd>
                <?php endif; ?>
            </dl>
        </div>
    </div>

    <div class="col-md-6">
        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Časový plán</h3>
            </div>
            <table class="<?php if ($match_data['Zavod_registrace_pozastaveno'] == "on") echo "d-none"; ?> table table-borderless m-2">
                <tr class="<?php if (empty($match_data['Squad_prem_max'])) echo "d-none"; ?>"><td><strong>Prematch</strong></td><td><?= "$denPrematch " . $datumPrematch->format('j.n.Y') . "" ?></td><td><?= htmlspecialchars($match_data['Zavod_cas_prematch'], ENT_QUOTES, 'UTF-8') ?></td></tr>
			<tr><td><strong>Prezence</strong></td><td><?= "$denZavod " . $datumZavod->format('j.n.Y') . "" ?></td><td><?= htmlspecialchars($match_data['Zavod_cas_prezence'], ENT_QUOTES, 'UTF-8') ?></td></tr>
			<tr class=" <?php if (!empty($match_data['Zavod_cas_main_dopoledne']) and !empty($match_data['Zavod_cas_main_odpoledne'])) echo "d-none"; ?>">
                    <td><strong>Závod</strong></td>
                    <td><?= "$denZavod " . $datumZavod->format('j.n.Y') . "" ?></td>
                    <td><?= htmlspecialchars($match_data['Zavod_cas_main'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr class="<?php if (empty($match_data['Zavod_cas_main_dopoledne']) or empty($match_data['Zavod_cas_main_odpoledne'])) echo "d-none"; ?>">
                    <td><strong>Závod</strong></td>
                    <td><?= "$denZavod " . $datumZavod->format('j.n.Y') . "" ?></td>
                    <td>dopolední směna: <?php if (!empty($match_data['Zavod_cas_main_dopoledne'])) echo htmlspecialchars($match_data['Zavod_cas_main_dopoledne'], ENT_QUOTES, 'UTF-8'); ?><br>odpolední směna: <?php if (!empty($match_data['Zavod_cas_main_odpoledne'])) echo htmlspecialchars($match_data['Zavod_cas_main_odpoledne'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
$zavod_divisions = [];
$result = $conn->query("SELECT * FROM " . $conn->real_escape_string($table_divisions) . " ORDER BY `Id` ASC");
while ($row = $result->fetch_assoc()) {
    $zavod_divisions[$row['Id']] = $row['Value'];
}
$zavod_categories = [];
$result = $conn->query("SELECT * FROM " . $conn->real_escape_string($table_categories) . " ORDER BY `Id` ASC");
while ($row = $result->fetch_assoc()) {
    $zavod_categories[$row['Id']] = $row['Name'];
}
?>
<div class="row my-3">
    <div class="col">
        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Další informace</h3>
            </div>
            <dl class="row  text-start">
                <dt class="col-sm-2 text-sm-end text-start ms-2">Divize:</dt>
                <dd class="col-sm-9 text-wrap px-4"><?= implode(', ', $zavod_divisions); ?>
                    <span class="text-danger small"><br>K vyhodnocení disciplíny dojde při počtu 3 a více závodníků</span>
                </dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Kategorie:</dt>
                <dd class="col-sm-9 text-wrap px-4"><?= implode(', ', $zavod_categories); ?>
                    <span class="text-danger small"><br>V závislosti na počtu závodníků v jednotlivých kategoriích může dojít k jejich sloučení</span>
                </dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Povinná výbava:</dt>
                <dd class="col-sm-9 px-4">ochrana sluchu a zraku (sluchátka, brýle)</dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Účast:</dt>
                <dd class="col-sm-9 px-4">Držitelé zbrojního průkazu</dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Zbraně a střelivo:</dt>
                <dd class="col-sm-9 px-4">Vlastní, jsou povoleny všechny druhy pušek, pistolí a revolverů dle jednotlivých disciplín. Není povoleno používat střelivo s průbojnou a zápalnou střelou.</dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Občerstvení:</dt>
                <dd class="col-sm-9 px-4">Zajištěno na střelnici</dd>
                <dt class="col-sm-2 text-sm-end text-start ms-2">Poznámky:</dt>
                <dd class="col-sm-9 px-4">
                    Střelci startují na vlastní náklady nebo na náklady vysílající organizace, na vlastní nebezpečí. Střelnice může vystavit doklad o zaplacení startovného.<br>
                    Střelci jsou odpovědní za způsobenou škodu a újmu.<br>
                    Pořadatel si vyhrazuje právo změn dle vzniklých objektivních situací.</dd>
            </dl>
        </div>
    </div>
</div>

<div class="row my-3">
    <div class="col-md-12">
        <div class="article">
            <div class="caption mb-2 p-2">
                <h3>Pravidla registrace</h3>
            </div>
            <ul class="pb-3 text-start">
                <li>V souladu s pravidlem 6.6.2 je účast v prematchi omezena na organizátory, rozhodčí, pomocníky a sponzory.</li>
                <li>Rozhodčí a pomocníci se registrují po dohodě s RM nebo MD</li>
                <li>Registrace se uzavírá 3 dny před konáním hlavního závodu.</li>
                <li>Pořadatelé si vyhrazují právo dodatečně měnit zařazení závodníků do squadů za účelem zajištění hladkého průběhu závodu.</li>
                <li><strong>Změny v registraci</strong> (např. náhrada závodníka při přenosu startovného) lze provést nejpozději v den prematche.</li>
                <li>Přesuny závodníků mezi squady na základě jejich žádosti lze provést nejpozději do 30 minut před oficiálním zahájením hlavního závodu.</li>
                <li><strong>Změny v průběhu závodu</strong> (např. divize, power faktor, kategorie,...) jsou zpoplatněné částkou 100 Kč.</li>
                <li>Protože jsou podklady pro zaplacení startovaného posílány emailem, zbavuje se závodník při zadání neplatné emailové adresy možnosti zúčastnit se závodu.</li>
            </ul>
        </div>
    </div>
</div>

<div class="row my-3 <?php if ($match_data['Payment_before'] == "") echo "d-none"; ?> ">
    <div class="col-md-6">
        <div class="article">
            <div class="caption mb-2 p-2">
                <H3>Úhrada startovného</H3>
            </div>
            <ul class="pb-3 text-start">
                <li>Startovné uhraďte tak, aby platba proběhla do <?= $match_data['Zavod_pocet_dni_na_platbu'] ?> dnů od registrace.<br>
                    - <span class="text-danger">u závodníků zaregistrovaných méně jak <?= $match_data['Zavod_pocet_dni_na_platbu'] ?> dní před závodem je třeba startovné zaplatit <b>nejpozději jeden den před prematchem</b></span>
                <li>V případě neuhrazení startovného v řádném termínu je registrace zrušena.<br>
                    <i>- neplatí pro organizátory, pomocníky a rozhodčí</i>
                <li><b>Startovné je nevratné, lze jej přenést na jiného závodníka.
                <li>Platíte-li za více závodníků, uveďte pouze jedno číslo a o platbě informujte pořadatele <a href='mailto:<?= $match_data['Zavod_email_from'] ?>'>e-mailem</A>.</b></i>
                <li><strong>Při platbě startovaného předem není registrace na místě možná.</strong></li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="article">
            <div class="caption mb-2 p-2">
                <H3>Platební údaje</H3>
            </div>
            <p class="font-monospace px-3  text-start">Číslo účtu: <?= "$match_data[Banka_ucet_cislo]/$match_data[Banka_ucet_kod]" ?><br>
                Jméno příjemce: <?= $match_data['Zavod_poradatel'] ?><br>
                Adresa příjemce: <?= $match_data['Zavod_poradatel_adresa'] ?>
            <p class="font-monospace px-3 pb-3">Banka: <?= $match_data['Banka_nazev'] ?><br>
                Adresa banky: <?= $match_data['Banka_adresa'] ?></p>
        </div>
    </div>
</div>

<div class="row my-3">
    <div class="col">
        <div class="article">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="caption mb-2 p-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <h3>Souhlas se zpracováním osobních údajů</h3>
                        </button>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ol>
                                <li>Udělujete tímto dobrovolně souhlas pořadateli <?= htmlspecialchars($match_data['Zavod_poradatel'], ENT_QUOTES, 'UTF-8') ?> (dále jen "Správce"), aby ve smyslu zákona č.101/2000 Sb., o ochraně osobních údajů (dále jen "zákon o ochraně osobních údajů") zpracovávala tyto osobní údaje:
                                    <ul>
                                        <li>jméno a příjmení</li>
                                        <li>datum narození</li>
                                        <li>e-mailová adresa</li>
                                        <li>telefonní číslo</li>
                                        <li>fotografie a videa z průběhu akce</li>
                                    </ul>
                                </li>
                                <li>Jméno, příjmení, datum narození, telefonní číslo, e-mailovou adresu a fotografie a videa z průběhu akce je nutné zpracovat:
                                    <ol type=\"a\">
                                        <li>za účelem registrace, evidence a vyhodnocení závodů který organizuje Správce.</li>
                                        <li>pro marketingové účely Správce, tj. zejména zveřejňování informací o průběžné činnosti Správce.</li>
                                    </ol>
                                    <br>Tyto údaje budou Správcem zpracovávány po dobu 5 let ode dne udělení souhlasu.<br><br>
                                </li>
                                <li>S výše uvedeným zpracováním udělujete svůj výslovný souhlas a prohlašujete, že poskytnuté osobní údaje jsou pravdivé. Souhlas lze vzít kdykoliv zpět, zasláním emailu nebo dopisu Správci.</li><br>
                                <li>Osobní údaje bude Správce zpracovávat manuálně nebo automaticky prostřednictvím svých zaměstnanců nebo dalších pořadatelů pověřených Správcem. Pro Správce mohou data zpracovávat případně i další poskytovatelé zpracovatelských softwarů, služeb a aplikací, které však v současné době Správce nevyužívá.</li><br>
                                <li>Vezměte, prosím, na vědomí, že podle zákona o ochraně osobních údajů máte právo:
                                    <ul>
                                        <li>vzít váš souhlas kdykoliv zpět,</li>
                                        <li>požadovat po nás informaci, jaké vaše osobní údaje zpracováváme,</li>
                                        <li>požadovat po nás vysvětlení ohledně zpracování osobních údajů,</li>
                                        <li>vyžádat si u nás přístup k těmto údajům a tyto nechat aktualizovat nebo opravit,</li>
                                        <li>požadovat po nás výmaz těchto osobních údajů,</li>
                                        <li>v případě pochybností o dodržování povinností souvisejících se zpracováním osobních údajů obrátit se na nás nebo na Úřad pro ochranu osobních údajů.</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include "footer.php"; ?>