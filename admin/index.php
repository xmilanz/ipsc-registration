<?php
include "header.php";
$admin = ['milan.zidek'];

?>
<div id="main">
    <div class="content">
        <button class="btn btn-secondary btn-rounded my-2" onclick="ToggleFilter()">Zobrazit / skrýt filtr</button>
        <?php
        $ip = $_SERVER['REMOTE_ADDR'];
        // Dotaz pro získání závodníků

        $table   = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $minSquad = -9;
        $stmt = $conn->prepare("
            SELECT 
        Cislo,
        Prijmeni    AS 'Příjmení',
        Jmeno       AS 'Jméno',
        Alias,
        ZP,
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
                if ($match_data['Payment_before'] == "on") {
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
            echo '<th>' . htmlspecialchars($header, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</th>';
        }
        echo '</tr></thead>';
        echo '<tbody>';
        // Pokud potřebujeme znovu projít výsledek od začátku
        $result->data_seek(0);

        // Pro součet zaplacených
        $sumaZaplaceno = [];

        while ($line = $result->fetch_assoc()) {
            // --- Logika pro třídu řádku, aktuální datum, součet plateb atp. ---
            $lineClass = '';
            if ($line['Zaplaceno'] === 'on') {
                $mena = $line['Mena'] ?? 'CZK';
                $sumaZaplaceno[$mena] = ($sumaZaplaceno[$mena] ?? 0) + (float)$line['Castka'];
            }

            // badge ikony stavu a statutu závodníka
            // stav
            $stavText = "čeká na platbu";
            $stavClass = "bg-secondary";

            if ($line['Squad'] == "-9") {
                $stavText = "";
                $stavClass = "";
            }
            if ($line['Squad'] == "-2") {
                $stavText = "čeká na zařazení";
                $stavClass = "bg-primary";
            }
            if ($line['NaMiste'] == "on") {
                $stavText = "platba na místě";
                $stavClass = "bg-info";
            }
            if ($line['Zaplaceno'] == "on" and ($line['Staff'] == "PAY")) {
                $stavText = "zaplaceno";
                $stavClass = "bg-success";
            }
            if ($line['Staff'] !== "PAY") {
                $stavText = "neplatí";
                $stavClass = "bg-success";
            }
            if (!empty($line['Urgence']) and $line['Zaplaceno'] !== "on") {
                $stavText = "urgence platby";
                $stavClass = "bg-danger";
            }
            if (($dnes >= date('Y-m-d', strtotime($line['Zaplatit'] . ' - 5 days')))
                && ($line['Squad'] >= 100)
                && ($line['Staff'] == "PAY")
                && ($line['Zaplaceno'] !== "on")
                && ($match_data['Payment_before'] == "on")
            ) {
                $stavText = "Nezaplaceno v limitu";
                $stavClass = "bg-danger";
            }

            // statut
            $staffText = 'platící závodník';
            $staffClass = "bg-secondary";

            if ($line['Squad'] == "-2") {
                $staffText = "čekatel";
                $staffClass = "bg-warning";
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
                            <?php if ($_SESSION['role'] === 'admin' or  $_SESSION['role'] === 'editor'): ?>
                                <button data-id="<?= $line['Cislo'] ?>" href="#edit_shooter"
                                    class="modal_edit_shooter btn text-secondary"
                                    data-bs-toggle="modal" title="Upravit závodníka">
                                    <i class="fas fa-edit"></i> Upravit
                                </button>
                                <button data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>" href="#send_regmail"
                                    class="modal_regmail btn text-secondary"
                                    data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false"
                                    title="Poslat registrační e-mail">
                                    <i class="fas fa-envelope"></i> E-mail
                                </button>
                            <?php endif; ?>
                            <button data-id="<?= $line['Cislo'] ?>" href="#info_shooter"
                                class="modal_info_shooter btn text-secondary"
                                data-bs-toggle="modal" title="Informace o závodníkovi">
                                <i class="fas fa-info-circle"></i> Info
                            </button>
                            <?php if ($line['Squad'] != "-9" || in_array($_SESSION['name'], $admin)): ?> <!-- není zaplaceno nebo platí na místě nebo už je vyřazen -->
                                <?php if ($_SESSION['role'] === 'admin' or  $_SESSION['role'] === 'editor'): ?>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn text-secondary" data-bs-toggle="dropdown" aria-expanded="false" title="Další akce">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php if ($line['Zaplaceno'] != "on" && $line['NaMiste'] != "on" && $line['Squad'] != "-9" && $line['Squad'] != "-2"): ?> <!-- není zaplaceno nebo platí na místě nebo už je vyřazen -->
                                                <li>
                                                    <button class="dropdown-item modal_payment_warn <?= $paymentBeforeClass ?>"
                                                        data-id="<?= $line['Cislo'] ?>" data-key="<?= $line['Klic'] ?>"
                                                        href="#payment_warn" data-bs-toggle="modal"
                                                        data-bs-backdrop="static" data-bs-keyboard="false">
                                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                        Upozornění na nezaplacení
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item modal_payment_save <?= $paymentBeforeClass ?>"
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
                                            <!--?php if (in_array($_SESSION['name'], $admin)): ?-->
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
                            <?php endif; ?>
                        </div>
                        </td>
        <?php
                        break;

                    default:
                        // standardní buňka
                        $value = $line[$col] ?? '';
                        echo "<td class='$col'>" . htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
                }
            }
            echo "</tr>";
        }
        echo '</tbody></table>';
        ?>

        <div class="my-3 <?= $paymentBeforeClass ?>">
            <h5>Vyúčtování</h5>
            <?php foreach ($sumaZaplaceno as $mena => $castka) {
                echo "&nbsp;- zaplaceno: $castka " . $match_data['Banka_ucet_MENA'] . "<br>";
            } ?>
        </div>

    </div>
    <div class="footer">Klub praktické střelby Eggenberg &copy; Milan Žídek <?= date("Y") ?><span style="float:right">IPSC match registration system 2.0</span></div>
</div>
<?php
include_once("./include/match_config.php");
include_once("./include/new.php");
include_once("./include/new_user.php");
include_once("./include/categories.php");
include_once("./include/divisions.php");
include_once("./include/squads.php");
include_once("./include/stages.php");
include_once("./include/users.php");
include_once("./include/pass_values.php");
?>

<div class="modal fade" id="info_shooter" tabindex="-1" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-center">
                <h4 class="modal-title text-white w-100 fw-bold">Informace o závodníkovi</h4>
                <br>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalID"> <!-- Skryté pole pro přenos ID -->
                <div id="modal-info-included">Načítám...</div>
            </div>
            <div class="modal-footer border-top-0 mt-3 col-12">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.modal_info_shooter').click(function() {
            var ID = $(this).data('id'); // Získáme ID z data-id
            $('#modalID').val(ID); // Uložíme ID do skrytého inputu

            $.post("information.php", {
                ID: ID
            }, function(result) {
                $("#modal-info-included").html(result); // Naplníme pouze obsah modalu
            });
        });
    });
</script>
<script type="text/javascript" src="./js/admin_scripts.js"></script>
<script type="text/javascript" src="./js/admin_reg_form.js"></script>


</BODY>

</HTML>