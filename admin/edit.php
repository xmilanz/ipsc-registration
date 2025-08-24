<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../config/data.php';
require_once __DIR__ . '/../db/dbconn.php';

$ID = isset($_POST['ID']) ? intval($_POST['ID']) : 0;

if ($ID > 0) {
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
    $line = mysqli_fetch_assoc($result);

    $Squad_old = $line['Squad'];

    $paymentBeforeClass = !empty($match_data['Payment_before']) ? '' : 'd-none';
    $zavodZbrojniPrukazClass = !empty($match_data['Zavod_zbrojni_prukaz']) ? '' : 'd-none';
    $staffLabels = [
        "PAY" => "platící&nbsp;závodník",
        "RO"  => "rozhodčí",
        "POM" => "pomocník",
        "VIP" => "VIP"
    ];
    $staffLabel = $staffLabels[$line['Staff']] ?? htmlspecialchars($line['Staff'], ENT_QUOTES, 'UTF-8');

    $faktorLabels = [
        "MIN" => "Minor",
        "MAJ"  => "Major"
    ];
    $faktorLabel = $faktorLabels[$line['Faktor']] ?? htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8');

    $nazev_divize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
    $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
    $nazev_squadu = getValueFromTable($conn, $table_squads, "Number", (int)$line['Squad'], "Name");
}
?>
<div class="row">
    <!-- ID závodníka -->
    <INPUT type="hidden" id="shooterID" name="shooterID" value="<?php echo htmlspecialchars($ID, ENT_QUOTES, 'UTF-8'); ?>" required>
    <!-- ID závodníka -->
    <!-- stav platby -->
    <INPUT type="hidden" id="Zaplaceno" name="Zaplaceno" value="<?php echo htmlspecialchars($line['Zaplaceno'], ENT_QUOTES, 'UTF-8'); ?>">
    <!-- stav platby -->
    <div class="col-md-10 fw-bolder">Osobní informace</div>

    <div class="row">
        <div class="col-md-6">
            <label for="Alias" class="form-label pt-2">IPSC alias</label>
            <input class="form-control" type="text" name="Alias" id="Alias" onkeypress="return avoidspace(event)" placeholder="NovakJ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'NovakJ'" value="<?php echo htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="invalid-feedback">Nevyplnili jste IPSC alias</div>
        </div>
        <div class="col-md-6 <?php echo "$zavodZbrojniPrukazClass"; ?>">
            <label for="ZP" class="form-label pt-2">Zbrojní průkaz</label>
            <input class="form-control" type="text" name="ZP" id="ZP" value="<?php echo htmlspecialchars($line['ZP'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="1234567890">
            <div class="invalid-feedback">Nevyplnili jste číslo zbrojního průkazu</div>
        </div>
        <div class="<?php if ($match_data['Zavod_zbrojni_prukaz'] == "on") {
                        echo "col-md-0";
                    } else {
                        echo "col-md-12";
                    }; ?>"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <label for="Jmeno" class="form-label pt-2">Jméno</label>
            <input class="form-control" type="text" name="Jmeno" id="Jmeno" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan'" value="<?php echo htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <div class="invalid-feedback">Nevyplnili jste jméno</div>
        </div>

        <div class="col-md-5">
            <label for="Prijmeni" class="form-label pt-2">Příjmení</label>
            <input class="form-control" type="text" name="Prijmeni" id="Prijmeni" onkeypress="return avoidspace(event)" placeholder="Novák" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" value="<?php echo htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <div class="invalid-feedback">Nevyplnili jste příjemní</div>
        </div>
        <div class="col-md-4">
            <label for="Prijmeni_stav" class="form-label pt-2">Doplnění jména</label>
            <select class="form-select" name=Prijmeni_stav>
                <option value="" selected>--- vyberte ---</option>
                <option value=" ml.">ml.</option>
                <option value=" st.">st.</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="Mail" class="form-label pt-3">Email</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input class="form-control" type="email" id="Mail" name="Mail" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?php echo htmlspecialchars($line['Mail'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <label for="Region" class="form-label pt-3">Region</label>
            <select class="form-select" name=Region>
                <option value="<?php echo htmlspecialchars($line['Region'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($line['Region'], ENT_QUOTES, 'UTF-8'); ?></option>
                <option value="AUT">Austria</option>
                <option value="CZE">Czech Republic</option>
                <option value="DEN">Denmark</option>
                <option value="GER">Germany</option>
                <option value="POL">Poland</option>
                <option value="SUI">Switzerland</option>
                <option value="SVK">Slovak Republic</option>
            </select>
        </div>

        <div class="col-md-10 pt-4 fw-bolder">Závod</div>
        <div class="row">
            <div class="col-md-6">
                <label for="Squad" class="form-label pt-2">Squad</label>
                <select class="form-select" name=Squad required>
                    <option value="<?php echo htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * from $table_squads ORDER BY Number");
                    while ($squad = mysqli_fetch_array($query)) {
                        echo "<option value=" . htmlspecialchars($squad['Number'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($squad['Name'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="Kategorie" class="form-label mt-2">Kategorie</label>
                <select class="form-select" name=Kategorie required>
                    <!--option value="<?php echo htmlspecialchars($line['Kategorie'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($line['Kategorie'], ENT_QUOTES, 'UTF-8'); ?></option-->
                    <option value="<?php echo htmlspecialchars($line['Kategorie'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $nazev_kategorie; ?></option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * from $table_categories ORDER BY Value");
                    while ($category = mysqli_fetch_array($query)) {
                        echo "<option value=" . htmlspecialchars($category['Name'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($category['Value'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="Divize" class="form-label pt-2">Divize</label>
                <select class="form-select" name=Divize required>
                    <!--option value="<?php echo htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8'); ?></option-->
                    <option value="<?php echo htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $nazev_divize; ?></option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * from $table_divisions ORDER BY Value");
                    while ($division = mysqli_fetch_array($query)) {
                        echo "<option value=" . htmlspecialchars($division['Name'], ENT_QUOTES, 'UTF-8') . ">" . htmlspecialchars($division['Value'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="Faktor" class="form-label pt-2">Power faktor</label>
                <select class="form-select" name=Faktor>
                    <option value="<?php echo htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $faktorLabel; ?></option>
                    <option value="MIN">Minor</option>
                    <option value="MAJ">Major</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="SquadReg" class="form-label pt-2">Squad před vyřazením</label>
                <input class="form-control" type="text" readonly class="form-control-plaintext" value="<?php echo htmlspecialchars($line['SquadReg'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" id="Squad_old" name="Squad_old" value="<?php echo htmlspecialchars($Squad_old, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>
        <div class="col-md-12 pt-4 fw-bolder">Ostatní</div>

        <div class="row <?php echo htmlspecialchars($paymentBeforeClass, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="col-md-6">
                <label for="Staff" class="form-label pt-2">Statut závodníka</label>
                <select class="form-select" name=Staff>
                    <option value="<?php echo htmlspecialchars($line['Staff'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $staffLabel; ?></option>
                    <option value="PAY">platící závodník</option>
                    <option value="VIP">VIP</option>
                    <option value="RO">rozhodčí</option>
                    <option value="POM">pomocník</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check form-check pt-5">
                    <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste" <?php if ($line['ZaplatiNaMiste'] == "on") {
                                                                                                                    echo "CHECKED";
                                                                                                                }; ?>>
                    <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <label for="Poznamka" class="form-label pt-3">Poznámka</label>
            <input class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="<?php echo htmlspecialchars($line['Poznamka'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
    </div>