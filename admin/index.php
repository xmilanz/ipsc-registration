<?php

declare(strict_types=1);
$paymentBeforeClass = ($match_data['Payment_before'] == 1) ? '' : 'd-none';

/**
 * Vykreslí sekci se seznamem závodníků (tabulka + vyúčtování + legenda).
 * Používá se jak při prvním načtení stránky, tak i při AJAX refreshi bez F5.
 */
function renderCompetitorsSection(
    mysqli $conn,
    string $table,
    array $match_data,
    string $dnes,
    string $paymentBeforeClass
): string {
    // ochrana proti SQL injection (název tabulky musí být čistý identifikátor)
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

    ob_start();
    // Dotaz pro získání závodníků
    $table   = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $minSquad = -9;
    $stmt = $conn->prepare("
            SELECT 
        Cislo,
        CASE WHEN Prijmeni LIKE '% %' THEN CONCAT(SUBSTRING_INDEX(Prijmeni, ' ', 1), ' ', Jmeno, ' ', SUBSTRING_INDEX(Prijmeni, ' ', -1)) ELSE CONCAT(Prijmeni, ' ', Jmeno) END AS PrijmeniJmeno,
        Alias,
        TRIM(CONCAT(ObcanskyPrukaz,' ',IF(ZbrojniOpravneni = 1, '(zo)', ''))) AS `Občanský průkaz`,
        CisloZbrane,
        Region,
        DatReg,
        Divize,
        Faktor,
        Kategorie,
        Squad,
        SquadReg,
        Staff,
        Klic,
        FROM_UNIXTIME(DatReg,'%d.%m.%Y %H:%i') AS Registrace,
        RegistraceIP    AS 'IP registrace',
        Mail,
        CastkaZaplatit  AS 'Startovné',
        DatPay          AS 'Zaplatit',
        VarSym          AS 'VS',
        ZaplatiNaMiste  AS 'NaMiste',
        Zaplaceno,
        Castka,
        DatumZaplaceni  AS 'Datum zaplaceni',
        Urgence,
        Vyrazeno,
        VyrazenoIP      AS 'IP vyrazení',
        Poznamka
            FROM $table
            WHERE Squad >= ?
            ORDER BY Cislo
        ");
    $stmt->bind_param(
        "i",
        $minSquad
    );

    $stmt->execute();
    $result = $stmt->get_result();

    // Načteme metadata sloupců jednou
    $fields   = [];
    $result->field_seek(0);
    while ($col = $result->fetch_field()) {
        if ($col->name === 'DatReg') {
            continue;
        }
        if ($col->name === 'VS') {
            $fields[] = 'Statut';
            if ($match_data['Payment_before']) {
                $fields[] = 'Stav';
            }
            $fields[] = 'Funkce';
        }
        $fields[] = $col->name;
    }

    // Vykreslení hlavičky
    echo '<table id="zavodnici" class="table table-striped table-bordered bg-white my-2 align-middle">';
    echo '<thead><tr>';

    foreach ($fields as $header) {
        echo '<th>' . htmlspecialchars((string)$header, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</th>';
    }
    echo '</tr></thead>';
    echo '<tbody>';
    // Pokud potřebujeme znovu projít výsledek od začátku
    $result->data_seek(0);

    // Pro součet zaplacených
    $sumaZaplaceno = [];

    while ($line = $result->fetch_assoc()) {
        // --- Logika pro třídu řádku, aktuální datum, součet plateb atp. ---
        if (!empty($line['Zaplaceno'])) {
            $mena = $line['Mena'] ?? 'CZK';
            $sumaZaplaceno[$mena] = ($sumaZaplaceno[$mena] ?? 0) + (float)($line['Castka'] ?? 0);
        }

        $lineClass = '';

        // badge ikony stavu a statutu závodníka
        // stav
        $stavText = "čeká na platbu";
        $stavClass = "bg-secondary";

        if ($line['Squad'] == "-9" && $line['Staff'] == "DNS") {
            $stavText = "";
            $stavClass = "";
            $lineClass = "zavodnik-vyrazeno";
        }
        if ($line['Squad'] == "-2") {
            $stavText = "čeká na zařazení";
            $stavClass = "bg-primary";
        }
        if ($line['NaMiste'] == 1) {
            $stavText = "platba na místě";
            $stavClass = "bg-info";
        }
        if ($line['Zaplaceno'] == 1 and ($line['Staff'] == "PAY")) {
            $stavText = "zaplaceno";
            $stavClass = "bg-success";
        }
        if ($line['Staff'] !== "PAY" && $line['Staff'] != "DNS") {
            $stavText = "neplatí";
            $stavClass = "bg-success";
        }
        if (!empty($line['Urgence']) and $line['Zaplaceno'] == 0) {
            $stavText = "urgence platby";
            $stavClass = "bg-danger";
        }
        if (($dnes >= date('Y-m-d', strtotime($line['Zaplatit'] . ' - 5 days')))
            && ($line['Squad'] >= 100)
            && ($line['Staff'] == "PAY")
            && ($line['Zaplaceno'] == 0)
            && ($match_data['Payment_before'] == 1)
        ) {
            $stavText = "Nezaplaceno v limitu";
            $stavClass = "bg-danger";
        }

        // statut
        $staffText = 'platící závodník';
        $staffClass = "bg-secondary";

        if ($line['Squad'] == "-2" && $match_data['Payment_before'] == 0) {
            $staffText = "čekatel";
            $staffClass = "bg-primary";
        }
        if ($line['Squad'] == "-9") {
            $staffText = "vyřazeno";
            $staffClass = "bg-dark";
        } elseif ($line['Staff'] == "RO") {
            $staffText = "rozhodčí";
            $staffClass = "bg-warning";
        } elseif ($line['Staff'] == "POM") {
            $staffText = "pomocník";
            $staffClass = "bg-warning";
        } elseif ($line['Staff'] == "VIP") {
            $staffText = "VIP";
            $staffClass = "bg-warning";
        }

        echo "<tr class='$lineClass'>";

        foreach ($fields as $col) {
            switch ($col) {
                case 'Zaplaceno':
                    echo "<td class='Zaplaceno'>";
                    if (!empty($line['Zaplaceno'])) {
                        echo "<center><i class='fas fa-coins' style='font-size:18px;color:#FF9900;'></i></center>";
                    }
                    echo "</td>";
                    break;

                case 'Statut':
                    echo "<td class='Statut'><span class='badge p-2 $staffClass'>$staffText</span></td>";
                    break;

                case 'Stav':
                    echo "<td class='Stav'><span class='badge p-2 $stavClass'>$stavText</span></td>";
                    break;

                case 'Funkce':
                    echo "<td class='functions'>";
?>
                    <div class="btn-group" role="group">
                        <button data-id="<?= $line['Cislo'] ?>" href="#info_shooter"
                            class="modal_info_shooter btn text-secondary"
                            data-bs-toggle="modal" title="Informace o závodníkovi">
                            <i class="fas fa-info-circle"></i> Info
                        </button>
                        <?php if (($_SESSION['role'] === 'admin' ||  $_SESSION['role'] === 'editor') && ($line['Squad'] != "-9")): ?>
                            <button data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>" href="#send_regmail"
                                class="modal_regmail btn text-secondary"
                                data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false"
                                title="Poslat registrační e-mail">
                                <i class="fas fa-envelope"></i> E-mail
                            </button>
                        <?php else: ?>
                            <button class="modal_regmail btn text-secondary disabled">
                                <i class="fas fa-envelope"></i> E-mail
                            </button>
                        <?php endif; ?>

                        <?php if (($_SESSION['role'] === 'admin') || ($line['Squad'] != "-9" && $_SESSION['role'] === 'editor')): ?>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn text-secondary" data-bs-toggle="dropdown" aria-expanded="false" title="Další akce">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if ($line['Zaplaceno'] != 1 && $line['NaMiste'] != 1 && $line['Squad'] != "-9" && $line['Squad'] != "-2"): ?> <!-- není zaplaceno nebo je zatím čekatel nebo  platí na místě nebo už je vyřazen -->
                                        <li>
                                            <button class="dropdown-item modal_payment_warn <?= hidden($match_data['Payment_before'] == 0); ?>"
                                                data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>"
                                                href="#payment_warning" data-bs-toggle="modal"
                                                data-bs-backdrop="static" data-bs-keyboard="false">
                                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                Upozornění na nezaplacení
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item modal_payment_save <?= hidden($match_data['Payment_before'] == 0); ?>"
                                                data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>"
                                                href="#payment_save" data-bs-toggle="modal"
                                                data-bs-backdrop="static" data-bs-keyboard="false">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Označit jako zaplaceno
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($line['Squad'] != "-9"): ?> <!-- není už vyřazen -->
                                        <li>
                                            <button class="dropdown-item modal_cancel_shooter"
                                                data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>"
                                                href="#cancel_shooter" data-bs-toggle="modal"
                                                data-bs-backdrop="static" data-bs-keyboard="false">
                                                <i class="fas fa-minus-circle text-danger me-2"></i>
                                                Vyřadit závodníka
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <li>
                                            <button class="dropdown-item modal_delete_shooter"
                                                data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>"
                                                href="#delete_shooter" data-bs-toggle="modal"
                                                data-bs-backdrop="static" data-bs-keyboard="false">
                                                <i class="fas fa-trash-alt text-danger me-2"></i>
                                                Smazat závodníka
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    </td>
    <?php
                    break;

                default:
                    // standardní buňka
                    $value = $line[$col] ?? '';
                    $colClass = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)$col);
                    echo "<td class='$colClass'>" . htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
            }
        }
        echo "</tr>";
    }
    echo '</tbody></table>';
    ?>

    <div class="ms-3 mb-3 <?= htmlspecialchars($paymentBeforeClass, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <h5>Vyúčtování</h5>
        <?php foreach ($sumaZaplaceno as $mena => $castka) {
            echo "&nbsp;- zaplaceno: " . htmlspecialchars((string)$castka, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " " . htmlspecialchars((string)($match_data['Banka_ucet_MENA'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "<br>";
        } ?>
    </div>
<?php

    return (string)ob_get_clean();
}

// AJAX endpoint pro refresh seznamu závodníků (bez reloadu stránky / F5)
if (isset($_GET['ajax']) && $_GET['ajax'] === 'competitors') {
    require_once __DIR__ . '/session_init.php';
    require_once __DIR__ . '/db/dbconn.php';
    require_once __DIR__ . '/functions.php';

    require_admin();

    // stejná inicializace dat závodu jako v header.php, ale bez výpisu HTML
    $table = (string)($_SESSION['zavod_id'] ?? '');
    if ($table === '') {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'missing_match'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result = $conn->query("SELECT * FROM $table_matches WHERE Zavod_id='" . $conn->real_escape_string($table) . "' LIMIT 1");
    if (!$result || $result->num_rows === 0) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'match_not_found'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $match_data = (array)$result->fetch_array();

    $paymentBeforeClass = (($match_data['Payment_before'] ?? 0) == 1) ? '' : 'd-none';
    $dnes = (new DateTime())->format("Y-m-d H:i:s");

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'html' => renderCompetitorsSection($conn, (string)$table, $match_data, $dnes, $paymentBeforeClass),
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

include __DIR__ . '/header.php';
?>
<div id="main">
    <div class="content">
        <button class="btn btn-outline-primary btn-rounded my-2 ms-2" onclick="ToggleFilter()">
            <i class="fas fa-solid fa-filter  me-1"></i>Zobrazit / skrýt filtr</button>
        <button id="refresh-competitors" class="btn btn-outline-primary btn-rounded my-2 ms-2" type="button">
            <i class="fas fa-sync-alt me-1"></i> Obnovit závodníky
        </button>
        <?php
        $ip = $_SERVER['REMOTE_ADDR'];
        ?>

        <div id="competitorsContainer">
            <?= renderCompetitorsSection($conn, (string)$table, (array)$match_data, (string)$dnes, (string)$paymentBeforeClass) ?>
        </div>
    </div>
    <div class="footer">KPS Eggenberg &copy; Milan Žídek <?= date("Y") ?><span style="float:right">IPSC match registration system 3.8</span></div>
</div>
<?php
include_once("./include/match_config.php");
include_once("./include/new.php");
include_once("./include/users.php");
include_once("./include/squads.php");
include_once("./include/divisions.php");
include_once("./include/categories.php");
include_once("./include/reg_fee.php");
include_once("./include/password_change.php");
include_once("./include/pass_values.php");
include_once("./include/stages.php");
include_once("./include/truncate_table.php");
?>

<script type="text/javascript" src="./js/admin_scripts.js"></script>
<script type="text/javascript" src="./js/admin_reg_form.js"></script>

<script>
    var paymentBefore = <?= json_encode($match_data['Payment_before'] == 1) ?>;
    var registraceSmeny = <?= json_encode($match_data['Zavod_registrace_smeny'] == 1) ?>;

    function bindCompetitorActionButtons() {
        var $root = $('#competitorsContainer');

        // odstraníme původní direct-handlery (jsou navázané při prvním načtení),
        // aby po refreshi nedocházelo k dvojitému spouštění
        $root.find('.modal_info_shooter').off('click').on('click', function() {
            var ID = $(this).data('id');
            $('#modalID').val(ID);
            $.post("information.php", {
                ID: ID
            }, function(result) {
                $("#modal-info-included").html(result);
            });
        });

        $root.find('.modal_regmail').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            $.ajax({
                url: 'regmail.php?ID=' + ID + '&KEY=' + KEY,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });


        $root.find('.modal_delete_shooter').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            $.ajax({
                url: 'delete.php?ID=' + ID + '&KEY=' + KEY,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });

        $root.find('.modal_cancel_shooter').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            $.ajax({
                url: 'cancel.php?ID=' + ID + '&KEY=' + KEY,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });

        $root.find('.modal_payment_warn').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            $.ajax({
                url: 'payment_warning.php?ID=' + ID + '&KEY=' + KEY,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });

        $root.find('.modal_payment_save').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            $.ajax({
                url: 'payment_save.php?ID=' + ID + '&KEY=' + KEY,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });

        $root.find('.modal_bulk_payment_warn').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            var BULK = $(this).attr('bulk-key');
            $.ajax({
                url: 'payment_warn_bulk.php?ID=' + ID + '&KEY=' + KEY + '&BULK=' + BULK,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });

        $root.find('.modal_bulk_payment_save').off('click').on('click', function() {
            var ID = $(this).attr('data-id');
            var KEY = $(this).attr('data-key');
            var BULK = $(this).attr('bulk-key');
            $.ajax({
                url: 'payment_save_bulk.php?ID=' + ID + '&KEY=' + KEY + '&BULK=' + BULK,
                cache: false,
                success: function(result) {
                    $(".modal-content").html(result);
                }
            });
        });
    }

    async function refreshCompetitors() {
        var $btn = $('#refresh-competitors');
        if ($btn.prop('disabled')) return;

        var originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Načítám...');

        try {
            const res = await fetch('index.php?ajax=competitors', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-store',
                credentials: 'same-origin'
            });

            if (res.status === 401) {
                // session vypršela – bezpečně přesměrujeme na plný reload
                window.location.href = 'index.php';
                return;
            }

            const data = await res.json();
            if (!data || !data.html) {
                throw new Error('Invalid response');
            }

            if (window.SSASAdmin && typeof window.SSASAdmin.destroyZavodniciDataTableIfExists === 'function') {
                window.SSASAdmin.destroyZavodniciDataTableIfExists();
            }
            document.getElementById('competitorsContainer').innerHTML = data.html;
            if (window.SSASAdmin && typeof window.SSASAdmin.initZavodniciDataTable === 'function') {
                window.SSASAdmin.initZavodniciDataTable({
                    paymentBefore: paymentBefore,
                    registraceSmeny: registraceSmeny
                });
            }
            bindCompetitorActionButtons();
        } catch (e) {
            console.error(e);
            alert('Nepodařilo se obnovit seznam závodníků. Zkuste to prosím znovu.');
        } finally {
            $btn.prop('disabled', false).html(originalHtml);
        }
    }

    $(document).ready(function() {
        // DataTables init řeší datatable_conf.js, tady řešíme jen akční tlačítka a refresh
        bindCompetitorActionButtons();
        $('#refresh-competitors').on('click', refreshCompetitors);
    });
</script>



</BODY>

</HTML>