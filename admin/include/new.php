<?php
$paymentBeforeClass = !empty($match_data['Payment_before']) ? '' : 'd-none';
$zavodZbrojniPrukazClass = !empty($match_data['Zavod_zbrojni_prukaz']) ? '' : 'd-none';
?>

<div class="modal fade" id="new_shooter" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header bg-primary text-center">
                <h4 class="modal-title text-white w-100 fw-bold">Nový závodník</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row needs-validation" method="post" action="./save.php?new_shooter" novalidate>
                    <?php
                    list($usec, $sec) = explode(" ", microtime());
                    echo "<INPUT TYPE=HIDDEN NAME=datreg VALUE=" . $sec . ">";
                    ?>

                    <div class="row">
                        <div class="col-md-8 fw-bolder">Osobní informace</div>
                        <div class="col-md-6">
                            <label for="Alias" class="form-label mt-2">IPSC alias</label>
                            <input pattern=".{3,16}" class="form-control" type="text" name="Alias" id="Alias" placeholder="3-16 znaků, bez diakritiky a spec. znaků" onfocus="this.placeholder = ''" onblur="this.placeholder = '3-16 znaků, bez diakritiky a spec. znaků';replaceChars()" required>
                            <label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
                            <div class="invalid-feedback">Nevyplnili jste IPSC alias nebo má neplatnou délku</div>
                        </div>
                        <div class="col-md-6 <?= $zavodZbrojniPrukazClass ?>">
                            <label for="ZP" class="form-label mt-2">Zbrojní průkaz</label>
                            <input class="form-control" type="text" name="ZP" id="ZP<?= $i ?>" placeholder="formát AB 123 456" onfocus="this.placeholder = ''" onblur="this.placeholder = 'formát AB 123 456'">
                        </div>
                        <div class="<?php if ($match_data['Zavod_zbrojni_prukaz'] == "on") {
                                        echo "col-md-0";
                                    } else {
                                        echo "col-md-12";
                                    }; ?>"></div>
                        <div class="col-md-3">
                            <label for="Jmeno" class="form-label mt-2">Jméno</label>
                            <input class="form-control" type="text" name="Jmeno" id="Jmeno" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan';replaceChars()" required>
                            <div class="invalid-feedback">Nevyplnili jste jméno</div>
                        </div>
                        <div class="col-md-5">
                            <label for="Prijmeni" class="form-label mt-2">Příjmení</label>
                            <input class="form-control" type="text" name="Prijmeni" id="Prijmeni" placeholder="Novák" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák';replaceChars()" required>
                            <div class="invalid-feedback">Nevyplnili jste příjmení</div>
                        </div>
                        <div class="col-md-4">
                            <label for="Prijmeni_stav" class="form-label mt-2">Doplnění jména</label>
                            <select class="form-select" name=Prijmeni_stav>
                                <option value="" selected>--- vyberte ---</option>
                                <option value=" ml.">ml.</option>
                                <option value=" st.">st.</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <label for="Mail" class="form-label mt-3">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input class="form-control" type="email" id="Mail" name="Mail" onfocus="this.placeholder = ''" onblur="this.placeholder='novak@mujemail.cz';replaceChars()" placeholder="novak@mujemail.cz" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="Region" class="form-label mt-3">Region</label>
                            <select name="Region" id="Region" class="form-select" required>
                                <option value="AUT">Austria</option>
                                <option value="CZE" selected>Czech Republic</option>
                                <option value="DEN">Denmark</option>
                                <option value="GER">Germany</option>
                                <option value="POL">Poland</option>
                                <option value="SUI">Switzerland</option>
                                <option value="SVK">Slovak Republic</option>
                            </select>
                            <div class="invalid-feedback">Nevybrali jste region</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mt-4 fw-bolder">Závod</div>
                        <div class="col-md-4">
                            <label for="Squad" class="form-label mt-2">Squad</label>
                            <select class="form-select" name=Squad required>
                                <option value="" selected>--- vyberte ---</option>
                                <?php
                                $stmt = $conn->prepare("SELECT * from $table_squads");
                                $stmt->execute();
                                $result_names = $stmt->get_result();
                                while ($line = $result_names->fetch_array()) {
                                    echo "<option value=" . $line['Number'] . ">" . $line['Name'] . "</option>";
                                }
                                $stmt->close();
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="Divize" class="form-label mt-2">Divize</label>
                            <select class="form-select" name="Divize" id="Divize" onchange="toggleDivizeMain()" required>
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
                        </div>
                        <div class="col-md-4 <?= $zavodMoreDivisionsClass ?>">
                            <label for="Divize_dalsi" class="form-label mt-2 mb-1 text-danger tooltip">
                                Další divize <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <span class="tooltiptext">
                                    <span>
                                        Při registraci závodníka ve více divizích se postupuje tímto způsobem:
                                        <ul>
                                            <li>Při první registaci použijte první seznam divizí.</li>
                                            <li>Po dokončení registrace vyberte squad a vyplňte stejné údaje (IPSC alias, Jméno, Příjmení, Email, Kategorie, Region).</li>
                                            <li>Další DIVIZI vyberte ze seznamu "Další divize"</li>
                                        </ul>
                                        <i>(jakmile se vybere jedna divize, není možné použít druhý seznam divizí)</i>
                                    </span>
                                </span>
                            </label>
                            <select class="form-select" name="Divize_dalsi" id="Divize_dalsi" onchange="toggleDivize()">
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
                        </div>
                        <div class="col-md-6">
                            <label for="Kategorie" class="form-label mt-2">Kategorie</label>
                            <select class="form-select" name=Kategorie required>
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
                        </div>
                        <div class="col-md-6">
                            <label for="Faktor" class="form-label mt-2">Faktor</label>
                            <select class="form-select" name=Faktor required>
                                <option value="" selected>--- vyberte ---</option>
                                <option value="MIN">Minor</option>
                                <option value="MAJ">Major</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-4 fw-bolder">Ostatní</div>
                        <div class="row ">
                            <div class="col-md-12 my-2">Statut závodníka</div>
                            <div class="col-md-6">
                                <select class="form-select" name=Staff>
                                    <option value="PAY">Platící závodník</option>
                                    <option value="VIP">VIP</option>
                                    <option value="RO">rozhodčí</option>
                                    <option value="POM">pomocník</option>
                                </select>
                            </div>
                            <div class="<?= $paymentBeforeClass ?> col-md-6 form-check form-check mt-6">
                                <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste">
                                <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="Poznamka" class="form-label mt-3">Poznámka</label>
                            <input class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="">
                        </div>
                    </div>
            </div>
            <!--Footer-->
            <div class="modal-footer border-top-0">
                <button type="submit" class="btn btn-primary">Přidat závodníka</button>
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít bez uložení</button>
            </div>
            </form>
        </div>
        <!--Content-->
    </div>
</div>