<?php
include "header.php";
?>
<div id="main">
    <div class="content">
        <button class="btn btn-secondary btn-rounded my-2" onclick="ToggleFilter()">Zobrazit / skrýt filtr</button>
        <?php
        $ip = $_SERVER['REMOTE_ADDR'];
        // Dotaz pro získání závodníků
        $query = " SELECT 
             		$table.Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,ZP,Region,DatReg,Divize,Faktor,Kategorie,Squad,SquadReg,Staff,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS  Registrace,RegistraceIP AS 'IP registrace',Mail,VarSym AS 'VS',DatPay AS 'Zaplatit',ZaplatiNaMiste AS 'NaMiste',Zaplaceno,Castka,DatumZaplaceni AS 'Datum zaplaceni',Urgence,Vyrazeno,VyrazenoIP AS 'IP vyrazeni',Poznamka
             	  FROM $table WHERE Squad >=-9 ";
        ?>

        <table id="zavodnici" class="table table-striped table-bordered bg-white my-2 ">
            <thead>
                <tr>
                    <?php
                    // Nový dotaz kvůli resetu výsledku (nebo opětovné použití po těle tabulky)
                    $result = $conn->query($query);
                    if ($result) {
                        while ($meta = $result->fetch_field()) {
                            $nazev = $meta->name;

                            if ($nazev == "DatReg") {
                                continue; // přeskočit
                            }

                            if ($nazev == "VS") {
                                echo "<th>Funkce</th>";
                            }

                            // Bezpečné HTML zobrazení hlavičky (kvůli &nbsp;, mezerám apod.)
                            echo "<th>" . htmlspecialchars($nazev, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</th>";
                        }
                    } else {
                        echo "<th>Chyba dotazu</th>";
                    }
                    ?>
                </tr>
            </thead>

            <?php
            $result = $conn->query($query);
            // Získat názvy sloupců
            $sloupce = [];
            while ($meta = $result->fetch_field()) {
                $sloupce[] = $meta->name;
            }

            // Smyčka přes řádky
            while ($row_array = $result->fetch_assoc()) {

                $z = $row_array;
                $rowClass = "";
                $dnes = date_format(new DateTime(), "Y-m-d");
                $DatReg = date('d.m.Y', $z['DatReg']);

                // harmonogram registrace
                // 1. zavodnik se zaregistruje
                // 2. při registraci se automaticky posle mail s platebními údaji (QR kód) a odkazem na zrušení registrace
                //	- z kontroly placení jsou vyřazeni: rozhodčí, pomocníci, VIP, čekatelé
                // 3. zavodnik do 10 dnu zaplatí nebo sám zruší registraci pomocí odkazu v registračním mailu
                // 4. závodník do 10 dnů nezaplatí (kontrola 10. den v 18:00) => automatické vyřazení


                // podminene formatovani
                if ($z['Squad'] == "-9") {
                    $rowClass .= " zrusenaregistrace";
                }
                if ($z['NaMiste'] == 'on') {
                    $rowClass .= " zaplatinamiste";
                }

                if ($z['Zaplaceno'] == 'on') {
                    $rowClass .= " zaplaceno";
                    $mena = $z['Mena'];

                    $castka = $z['Castka'];
                    $sumaZaplaceno[$mena] = $sumaZaplaceno[$mena] + $castka;
                }

                if ($z['Urgence'] != "") {
                    $rowClass .= " urgence";
                }

                if ((($dnes >= date('Y-m-d', strtotime($z['Zaplatit'] . ' - 5 days'))) and ($row_array['Squad'] >= 100) and ($row_array['Staff'] == "PAY") and ($row_array['Zaplaceno'] !== "on") and ($match_data['Payment_before'] == "on"))) {
                    $rowClass .= " nezaplacenopolimitu";
                }
                // konec podminene formatovani

                echo "<TR class='$rowClass'>";
                foreach ($sloupce as $pole) {
                    if ($pole == "DatReg") {
                        continue;
                    }

                    if ($pole == "Zaplaceno") {
                        echo "<TD class='$pole'>";
                        if (!empty($row_array['Zaplaceno'])) {
                            echo "<center><i class='fas fa-coins' style='font-size:18px; color:#FF9900;'></i></center>";
                        }
                        echo "</TD>";
                    } elseif ($pole == "VS") {
                        echo "<td class='functions'>";
                        if (intval($row_array['Squad']) > -10) {
                            echo "<a data-id='{$row_array['Cislo']}' href='#edit_shooter' class='modal_edit_shooter' data-bs-toggle='modal' title='Upravit závodníka'><i class='fas fa-edit' style='font-size:15px'></i></a>";
                            echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#send_regmail' class='modal_regmail' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Poslat závodníkovi registrační email'><i class='fas fa-envelope 1' style='font-size:15px'></i></a>";
                            if ($row_array['Zaplaceno'] !== "on" and $row_array['NaMiste'] !== "on") {
                                echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#payment_warn' class='modal_payment_warn $paymentBeforeClass' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Poslat závodníkovi upozornění na nezaplacení'><i class='fas fa-exclamation-triangle 1' style='font-size:15px;color:gold;'></i></a>";
                                echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#payment_save' class='modal_payment_save $paymentBeforeClass' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Označit jako ZAPLACENO'><i class='fas fa-check-circle 1' style='font-size:15px;color:#40a73f;'></i></a>";
                            }
                            echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#cancel_shooter' class='modal_cancel_shooter' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Vyřadit závodníka'><i class='fas fa-minus-circle 1' style='font-size:15px;color:#6d757d;'></i></a>";
                            echo "&nbsp;<a data-id='$row_array[Cislo]' href='#info_shooter' class='modal_info_shooter' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Informace o závodníkovi'><i class='fas fa-info-circle 1 text-warning' style='font-size:16px;'></i></a>";
                            if ($_SESSION['name'] == "milan.zidek") {
                                echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#delete_shooter' class='modal_delete_shooter' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-keyboard='false' title='Smazat závodníka'><i class='fas fa-trash-alt' style='font-size:15px;color:#ff0000;' 1></i></a>";
                            }
                        }
                        echo "</td>";
                        echo "<TD class='$pole'>{$row_array[$pole]}</TD>";
                    } else {
                        echo "<TD class='$pole'>" . ($row_array[$pole] ?? '') . "</TD>";
                    }
                }
                echo "</TR>";
            }
            ?>
        </table>
        <div class="mt-3<?php echo "$paymentBeforeClass"; ?>">
            <h5>Vyúčtování</h5>
            <?php foreach ($sumaZaplaceno as $mena => $castka) {
                echo "&nbsp;- zaplaceno: $castka CZK";
            } ?>
        </div>
        <div class="my-4">
            <h5>Legenda</h5>
            &nbsp;- registrováno<br>
            <span class="<?php echo "$paymentBeforeClass"; ?>">
                &nbsp;- VIP neplatí (automaticky se potvrdí účast a neposílá se urgence ani se automaticky nevyřadí)<br>
                &nbsp;- <span style='background-color: #9fff9f'>zaplaceno<br></span>
                &nbsp;- <span style='color: #7433FF'>zaplatí na místě<br></span>
                &nbsp;- <span style='color: #ff0000; '>ruční urgence před limitem<br></span>
                &nbsp;- <span style='color: #ff0000; font-weight: bolder; '>zbývá méně jak 5 dní do zaplacení<br></span>
            </span>
            &nbsp;- <span style='color:#858585;background-color: #d3d3d3'>vyřazeno</span></i>)
        </div>
    </div>
    <div class="footer">SSAŠ střelnice Prachatice &copy; Milan Žídek <?php echo date("Y"); ?><span style="float:right">Shooting match registration system 1.0</span></div>
</div>
<?php
include_once("./include/match_config.php");
include_once("./include/new.php");
include_once("./include/categories.php");
include_once("./include/divisions.php");
include_once("./include/squads.php");
include_once("./include/stages.php");
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