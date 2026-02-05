<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../config/data.php';
require_once __DIR__ . '/../db/dbconn.php';

$ID = isset($_POST['ID']) ? intval($_POST['ID']) : 0;

$stmt = $conn->prepare("
        SELECT * FROM $table
        WHERE Cislo = ?
     ");
$stmt->bind_param(
    "i",
    $ID
);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();


if ($result && mysqli_num_rows($result) > 0) {
    $line = mysqli_fetch_assoc($result);

    $Squad_old = $line['Squad'];

    $staffLabels = [
        "PAY" => "platící závodník",
        "RO"  => "rozhodčí - neplatí",
        "POM" => "pomocník - neplatí",
        "VIP" => "VIP - neplatí"
    ];
    $staffLabel = $staffLabels[$line['Staff']] ?? htmlspecialchars($line['Staff'], ENT_QUOTES, 'UTF-8');

    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");

    $paymentBeforeClass = !empty($match_data['Payment_before']) ? '' : 'd-none';
    $zavodObcanskyPrukazClass = !empty($match_data['Zavod_obcansky_prukaz']) ? '' : 'd-none';
?>
    <!-- ID závodníka -->
    <INPUT type="hidden" id="shooterID" name="shooterID" value="<?= htmlspecialchars($ID, ENT_QUOTES, 'UTF-8') ?>" required>
    <!-- puvodni squad -->
    <input type="hidden" id="Squad_old" name="Squad_old" value="<?= htmlspecialchars($Squad_old, ENT_QUOTES, 'UTF-8') ?>">
    <!-- stav platby -->
    <INPUT type="hidden" id="Zaplaceno" name="Zaplaceno" value="<?= htmlspecialchars($line['Zaplaceno'], ENT_QUOTES, 'UTF-8') ?>">

    <div class='accordion' id='accordionInformation'>
        <div class='accordion-item'>
            <h2 class='accordion-header'>
                <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
                    Základní informace
                </button>
            </h2>
            <div id='collapseOne' class='accordion-collapse collapse show' data-bs-parent='#accordionInformation'>
                <div class='accordion-body'>
                    <div class='row pb-3'>
                        <div class='col-md-4 pt-1'>
                            <label class='form-label'>IPSC Alias</label>
                            <input class="form-control" type="text" name="Alias" id="Alias" onkeypress="return avoidspace(event)" placeholder="IPSC alias" onfocus="this.placeholder = ''" onblur="this.placeholder = 'IPSC alias'" value="<?= htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col-md-4 <?= $zavodObcanskyPrukazClass ?> pt-1">
                            <label class='form-label'>Číslo OP / EZP</label>
                            <input class="form-control" type="text" name="ObcanskyPrukaz" id="ObcanskyPrukaz" value="<?= htmlspecialchars($line['ObcanskyPrukaz'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-4 pt-4 mt-2">
                            <input type="checkbox" class="form-check-input" id="ZbrojniOpravneni" name="ZbrojniOpravneni" <?php echo ($line['ZbrojniOpravneni'] == "on") ? "CHECKED" : ""; ?>>
                            <label class="form-check-label" for="ZbrojniOpravneni">Zbrojní oprávnění</label>
                        </div>
                    </div>
                    <div class='row pb-3'>

                        <div class='col-md-6'>
                            <label class='form-label pt-1'>Jméno</label>
                            <input class="form-control" type="text" name="Jmeno" id="Jmeno" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan'" value="<?= htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label pt-1'>Příjmení</label>
                            <input class="form-control" type="text" name="Prijmeni" id="Prijmeni" onkeypress="return avoidspace(event)" placeholder="Novák" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" value="<?= htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class='row pb-3'>
                        <div class='col-md-8'>
                            <label class='form-label pt-1'>E-mail</label>
                            <input class="form-control" type="email" id="Mail" name="Mail" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?= htmlspecialchars($line['Mail'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class='col-md-4'>
                            <label class='form-label pt-1'>Region</label>
                            <select class='form-select' name='Region' id='Region'>
                                <option value="<?= htmlspecialchars($line['Region'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($line['Region'], ENT_QUOTES, 'UTF-8') ?></option>
                                <option value="AUT">Austria</option>
                                <option value="CZE">Czech Republic</option>
                                <option value="DEN">Denmark</option>
                                <option value="GER">Germany</option>
                                <option value="POL">Poland</option>
                                <option value="SUI">Switzerland</option>
                                <option value="SVK">Slovak Republic</option>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            <label class='form-label pt-1'>Poznámka</label>
                            <textarea class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'"><?= htmlspecialchars($line['Poznamka'], ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='accordion-item'>
            <h2 class='accordion-header'>
                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' aria-expanded='false' data-bs-target='#collapseTwo' aria-controls='collapseTwo'>
                    Závod
                </button>
            </h2>
            <div id='collapseTwo' class='accordion-collapse collapse' data-bs-parent='#accordionInformation'>
                <div class='accordion-body'>
                    <div class='row pb-3'>
                        <div class='col-md-3'>
                            <label class='form-label pt-1'>Squad</label>
                            <select class='form-select' name='Squad' id='Squad'>
                                <option value="<?= htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * from $table_squads WHERE NOT `Number` = '-9' ORDER BY Number");
                                while ($squad = mysqli_fetch_array($query)) {
                                    echo "<option value=" . htmlspecialchars($squad['Number'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($squad['Name'], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='col-md-4 <?= (empty($line['SquadReg']) ? 'd-none' : '') ?>'>
                               <label class='form-label'>Squad před vyřazením</label>
                               <input readonly class='bg-light text-dark form-control' id='SquadReg' name='SquadReg' value='<?= $line['SquadReg'] ?>'>
                         </div>
                    </div>
                    <div class='row pb-3'>
                        <div class='col-md-4'>
                            <label class='form-label'>Divize</label>
                            <select class="form-select" name='Divize' id='Divize'>
                                <option value="<?= htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8') ?>"><?= $nazev_divize ?></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * from $table_divisions ORDER BY Value");
                                while ($division = mysqli_fetch_array($query)) {
                                    echo "<option value=" . htmlspecialchars($division['Name'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($division['Value'], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Faktor</label>
                            <select class="form-select" name='Faktor' id='Faktor'>
                            <option value="<?= htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8') ?>"><?= $faktorLabel ?></option>
                                <option value="MIN">Minor</option>
                                <option value="MAJ">Major</option>
                            </select>
                        </div>
                        <div class='col-md-5'>
                            <label class='form-label'>Kategorie</label>
                            <select class="form-select" name='Kategorie' id='Kategorie' required>
                                <option value="<?= htmlspecialchars($line['Kategorie'], ENT_QUOTES, 'UTF-8') ?>"><?= $nazev_kategorie ?></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * from $table_categories ORDER BY Value");
                                while ($category = mysqli_fetch_array($query)) {
                                    echo "<option value=" . htmlspecialchars($category['Name'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($category['Value'], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='row pb-3'>
                           <div class='col-md-4'>
                            <label class='form-label'>Statut</label>
                            <select class="form-select" name=Staff>
                                <option value="<?= htmlspecialchars($line['Staff'], ENT_QUOTES, 'UTF-8') ?>"><?= $staffLabel ?></option>
                                <option value="VIP">VIP</option>
                                <option value="PAY">platící závodník</option>
                                <option value="RO">rozhodčí</option>
                                <option value="POM">pomocník</option>
                            </select>
                        </div>
                        <div class='col-md-4 pt-4 mt-2 <?php echo (($line['Staff'] == "PAY") && ($match_data['Payment_before'] == "on")) ? '' : 'd-none' ?>'>
                            <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste" <?php echo ($line['ZaplatiNaMiste'] == "on") ? "CHECKED" : ""; ?>>
                            <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='accordion-item'>
            <h2 class='accordion-header'>
                <button class='accordion-button collapsed <?= (!empty($line['Vyrazeno']) ? 'bg-secondary text-white' : '') ?>' type='button' data-bs-toggle='collapse' data-bs-target='#collapseThree' aria-expanded='false' aria-controls='collapseThree'>
                    Registrace a vyřazení
                </button>
            </h2>
            <div id='collapseThree' class='accordion-collapse collapse' data-bs-parent='#accordionInformation'>
                <div class='accordion-body'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <label class='form-label pt-1'>Datum registrace</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= gmdate("d.m.Y H:i", htmlspecialchars($line['DatReg'], ENT_QUOTES, 'UTF-8')) ?>'>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label pt-1'>IP registrace</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= htmlspecialchars($line['RegistraceIP'], ENT_QUOTES, 'UTF-8') ?>'>
                        </div>
                        <div class='col-md-12 py-2'></div>
                        <div class='col-md-6'>
                            <label class='form-label pt-1'>Datum a čas vyřazení</label>
                            <input readonly class='bg-light form-control' value='<?= (!empty($line['Vyrazeno']) ? date('d.m.Y H:i', strtotime($line['Vyrazeno'])) : '---') ?>'>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label pt-1'>IP vyřazení</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= (!empty($line['VyrazenoIP']) ? htmlspecialchars($line['VyrazenoIP'], ENT_QUOTES, 'UTF-8') : '---') ?>'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='accordion-item <?= $paymentBeforeClass  ?>'>
            <h2 class='accordion-header'>
                <button class='accordion-button collapsed <?= (!empty($line['Zaplaceno']) ? 'bg-success text-white' : '') ?>' type='button' data-bs-toggle='collapse' data-bs-target='#collapseFour' aria-expanded='false' aria-controls='collapseFour'>
                    Placení
                </button>
            </h2>
            <div id='collapseFour' class='accordion-collapse collapse' data-bs-parent='#accordionInformation'>
                <div class='accordion-body'>
                    <div class='row'>
                        <div class='col-md-3'>
                            <label class='form-label pt-1'>VS</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= htmlspecialchars($line['VarSym'], ENT_QUOTES, 'UTF-8') ?>'>
                        </div>
                        <div class='col-md-4'>
                            <label class='form-label pt-1'>Zaplatit do</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= (!empty($line['ZaplatiNaMiste']) ? 'na místě' : htmlspecialchars($line['DatPay'], ENT_QUOTES, 'UTF-8')) ?>'>
                        </div>
                        <div class='col-md-4 <?= (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') ?>'>
                            <label class='form-label pt-1'>Urgence</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= (!empty($line['Urgence']) ? htmlspecialchars($line['Urgence'], ENT_QUOTES, 'UTF-8') : '---') ?>'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4 <?= (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') ?>'>
                            <label class='form-label pt-1'>Zaplaceno dne</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= (!empty($line['DatumZaplaceni']) ? date('d.m.Y H:i', strtotime($line['DatumZaplaceni'])) : '---') ?>'>

                        </div>
                        <div class='col-md-3 <?= (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') ?>'>
                            <label class='form-label pt-1'>Částka (Kč)</label>
                            <input readonly class='bg-light text-dark form-control' value='<?= (!empty($line['Castka']) ? htmlspecialchars($line['Castka'], ENT_QUOTES, 'UTF-8') : '---') ?>'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
