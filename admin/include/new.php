<?php
$paymentBeforeClass = !empty($match_data['Payment_before']) ? '' : 'd-none';
$zavodObcanskyPrukazClass = !empty($match_data['Zavod_obcansky_prukaz']) ? '' : 'd-none';
?>

<div class="modal fade" id="new_shooter" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-center">
                <h4 class="modal-title text-white w-100 fw-bold">Nový závodník</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row needs-validation" method="post" action="./save.php" novalidate>
                    <?php
                    list($usec, $sec) = explode(" ", microtime());
                    echo "<INPUT TYPE=HIDDEN NAME=datreg VALUE=" . $sec . ">";
                    ?>
                    <div class="row m-1">
                        <fieldset class="border p-2 rounded">
                            <legend class="float-none w-auto px-2 h6">Osobní informace</legend>
                            <div class="row mx-1">
                                <div class="col-md-4">
                                    <label for="Alias" class="form-label mt-2">IPSC alias
                                        <a
                                            href="#"
                                            role="button"
                                            tabindex="0"
                                            id="userInfoBtn"
                                            data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-html="true"
                                            data-bs-title="IPSC alias"
                                            data-bs-content="IPSC Alias má délku 3 - 16 znaků. Nesmí obsahovat znaky s diakritkou (háčky a čárky) a speciální znaky (<|>@#$^&*...)">
                                            <sup><i class="fas fa-question-circle text-primary ms-1"></i></sup>
                                        </a>
                                    </label>
                                    <input pattern=".{3,16}" class="form-control" type="text" name="Alias" id="Alias" placeholder="3-16 znaků" onfocus="this.placeholder = ''" onblur="this.placeholder = '3-16 znaků';replaceChars()" required>
                                    <label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
                                    <div class="invalid-feedback">Nevyplnili jste IPSC alias nebo má neplatnou délku</div>
                                </div>

                                <div class="col-md-4 <?= $zavodObcanskyPrukazClass ?>">
                                    <label for="ObcanskyPrukaz" class="form-label mt-2">Číslo OP / EZP
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
                                    <input class="form-control" type="text" name="ObcanskyPrukaz" id="ObcanskyPrukaz" placeholder="0123456789" onfocus="this.placeholder = ''" onblur="this.placeholder = '0123456789'">
                                </div>
                                <div class="col-md-4 pt-4 mt-2 <?= $zavodObcanskyPrukazClass ?>">
                                    <label class="form-check-label" for="ZbrojniOpravneni">
                                        <input type="checkbox" class="form-check-input" id="ZbrojniOpravneni" name="ZbrojniOpravneni"> Zbrojní oprávnění
                                    </label>
                                </div>
                            </div>
                            <div class="row mx-1">
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
                            <div class="row mx-1 mb-3">
                                <div class="col-md-8">
                                    <label for="Mail" class="form-label mt-3">E-mail</label>
                                    <input class="form-control" type="email" id="Mail" name="Mail" onfocus="this.placeholder = ''" onblur="this.placeholder='novak@mujemail.cz';replaceChars()" placeholder="novak@mujemail.cz" value="" required>
                                    <div class="invalid-feedback">Nevyplnili jste e-mail</div>
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
                        </fieldset>
                    </div>

                    <div class="row m-1">
                        <fieldset class="border p-2 rounded">
                            <legend class="float-none w-auto px-2 h6">Závod</legend>
                            <div class="row mx-1">
                                <div class="col-md-4">
                                    <label for="Squad" class="form-label">Squad</label>
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
                                    <label for="Divize" class="form-label">Divize</label>
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
                                    <label for="Divize_dalsi" class="form-label mb-1 text-danger">
                                        Další divize <a
                                            href="#"
                                            role="button"
                                            tabindex="0"
                                            id="userInfoBtn"
                                            data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-html="true"
                                            data-bs-title="Registrace do více divizí"
                                            data-bs-content="Střílí-li závodník ve více divizích, postupujte tímto způsobem:
								<ul>
									<li>Při první registaci se použij první seznam divizí.</li>
									<li>Po dokončení registrace se vyberte squad a vyplňte stejné údaje <br>(IPSC alias, Jméno, Příjmení, Email, Kategorie, Region).</li>
									<li>Další DIVIZI vyberte ze seznamu 'Další divize'</li>
								</ul>
								<i>(jakmile se vybere jedna divize, není možné použít druhý seznam divizí)</i>
								">
                                            <sup><i class="fas fa-question-circle text-primary ms-1"></i></sup>
                                        </a>
                                    </label>
                                    <select class="form-select" name="Divize_dalsi" id="Divize_dalsi" onchange="toggleDivize()">
                                        <option value="" selected>--- vyberte ---</option>
                                        <?php
                                        $stmt = $conn->prepare("SELECT * from $table_divisions");
                                        $stmt->execute();
                                        $result_names = $stmt->get_result();
                                        while ($line = $result_names->fetch_array()) {
                                            //                                    echo "<option value=" . $line['Name'] . ">" . $line['Value'] . "</option>";
                                            echo "<option value=" . '-' . $line['Name'] . ">" . $line['Value'] . "</option>";
                                        }
                                        $stmt->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mx-1 pb-3">
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
                        </fieldset>
                    </div>

                    <div class="row m-1">
                        <fieldset class="border p-2 rounded">
                            <legend class="float-none w-auto px-2 h6">Ostatní</legend>
                            <div class="row mx-1">
                                <div class="col-md-12 my-2">Statut závodníka</div>
                                <div class="col-md-6">
                                    <select class="form-select" name=Staff>
                                        <option value="PAY">Platící závodník</option>
                                        <option value="VIP">VIP</option>
                                        <option value="RO">rozhodčí</option>
                                        <option value="POM">pomocník</option>
                                    </select>
                                </div>
                                <div class="<?= $paymentBeforeClass ?> col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste">
                                    <label class="form-check-label " for="ZaplatiNaMiste">Zaplatí na místě</label>
                                </div>
                            </div>
                            <div class="col-md-12 px-3 pb-3 ">
                                <label for="Poznamka" class="form-label mt-3">Poznámka</label>
                                <textarea class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value=""></textarea>
                            </div>
                        </fieldset>
                    </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="submit" name="new_shooter" class="btn btn-primary">Přidat závodníka</button>
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít bez uložení</button>
            </div>
            </form>
        </div>
    </div>
</div>