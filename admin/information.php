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

    if ($result && mysqli_num_rows($result) > 0) {
        $line = mysqli_fetch_assoc($result);

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

        echo /* html */ "
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
                    <div class='col-md-6'>
                        <label class='form-label pt-1'>Jméno</label>
                        <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
                    <div class='col-md-6'>
                       <label class='form-label pt-1'>Příjmení</label>
                       <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
               </div>
               <div class='row pb-3'>
                    <div class='col-md-4'>
                       <label class='form-label'>IPSC alias</label>
                       <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
                    <div class='col-md-5'>
                  <label class='form-label pt-1'>E-mail</label>
                       <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Mail'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
                    <div class='col-md-3'>
                    <label class='form-label'>Region</label>
                    <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Region'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
                </div>
                    
                <div class='row pb-3'>
                    <div class='col-md-6 " . (!empty($match_data['Zavod_zbrojni_prukaz']) ? '' : 'd-none') . "'>
                       <label class='form-label pt-1'>Zbrojní průkaz</label>
                       <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['ZP'], ENT_QUOTES, 'UTF-8') . "'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                  <label class='form-label pt-1'>Poznámka</label>
                       <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Poznamka'], ENT_QUOTES, 'UTF-8') . "'>
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
                  <div class='col-md-2'>
                        <label class='form-label'>Číslo</label>
                        <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Cislo'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-3 " . ($line['Squad'] == '-9' ? 'd-none' : '') . "'>
                     <label class='form-label'>Squad</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-5 " . (empty($line['SquadReg']) ? 'd-none' : '') . "'>
                     <label class='form-label'>Squad před vyřazením</label>
                     <input readonly class='bg-light text-muted form-control'  value='" . htmlspecialchars($line['SquadReg'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-5'>
                     <label class='form-label'>Statut závodníka</label>
                     <input readonly class='bg-light text-dark form-control' value=$staffLabel>
                  </div>
              </div>
              <div class='row pb-3'> 
                  <div class='col-md-5'>
                        <label class='form-label'>Kategorie</label>
                        <input readonly class='bg-light text-dark form-control'  value='$nazev_kategorie'>
                  </div>

                  <div class='col-md-4'>
                        <label class='form-label'>Divize</label>
                        <input readonly class='bg-light text-dark form-control'  value='$nazev_divize'>
                  </div>

                  <div class='col-md-3'>
                        <label class='form-label'>Faktor</label>
                        <input readonly class='bg-light text-dark form-control'  value='$faktorLabel'>
                  </div>

              </div>
            </div>
         </div>
      </div>
      <div class='accordion-item'>
         <h2 class='accordion-header'>
            <button class='accordion-button collapsed " . (!empty($line['Vyrazeno']) ? 'bg-secondary text-white' : '') . "' type='button' data-bs-toggle='collapse' data-bs-target='#collapseThree' aria-expanded='false' aria-controls='collapseThree'>
            Registrace a vyřazení
            </button>
         </h2>
         <div id='collapseThree' class='accordion-collapse collapse' data-bs-parent='#accordionInformation'>
            <div class='accordion-body'>
               <div class='row'>
                  <div class='col-md-6'>
                     <label class='form-label pt-1'>Datum registrace</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . gmdate("d.m.Y H:i", htmlspecialchars($line['DatReg'], ENT_QUOTES, 'UTF-8')) . "'>
                  </div>
                  <div class='col-md-6'>
                     <label class='form-label pt-1'>IP registrace</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['RegistraceIP'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-12 py-2'></div>
                  <div class='col-md-6'>
                     <label class='form-label pt-1'>Datum a čas vyřazení</label>
                     <input readonly class='bg-light form-control' value='" . (!empty($line['Vyrazeno']) ? date('d.m.Y H:i', strtotime($line['Vyrazeno'])) : '---') . "'>
                  </div>
                  <div class='col-md-6'>
                     <label class='form-label pt-1'>IP vyřazení</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . (!empty($line['VyrazenoIP']) ? htmlspecialchars($line['VyrazenoIP'], ENT_QUOTES, 'UTF-8') : '---') . "'>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class='accordion-item " . (empty($match_data['Payment_before']) ? 'd-none' : '') . "'>
         <h2 class='accordion-header'>
            <button class='accordion-button collapsed " . (!empty($line['Zaplaceno']) ? 'bg-success text-white' : '') . "' type='button' data-bs-toggle='collapse' data-bs-target='#collapseFour' aria-expanded='false' aria-controls='collapseFour'>
            Placení 
            </button>
         </h2>
         <div id='collapseFour' class='accordion-collapse collapse' data-bs-parent='#accordionInformation'>
            <div class='accordion-body'>
               <div class='row'>
                  <div class='col-md-3'>
                     <label class='form-label pt-1'>Klíč</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['klic'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-3'>
                     <label class='form-label pt-1'>VS</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . htmlspecialchars($line['VarSym'], ENT_QUOTES, 'UTF-8') . "'>
                  </div>
                  <div class='col-md-4'>
                     <label class='form-label pt-1'>Zaplatit do</label>
                     <input readonly class='bg-light text-dark form-control' value='" . (!empty($line['ZaplatiNaMiste']) ? 'na místě' : htmlspecialchars($line['DatPay'], ENT_QUOTES, 'UTF-8')) . "'>
                  </div>
                  <div class='col-md-12 py-2'></div>
                  <div class='col-md-4 " . (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') . "'>
                     <label class='form-label pt-1'>Urgence</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . (!empty($line['Urgence']) ? htmlspecialchars($line['Urgence'], ENT_QUOTES, 'UTF-8') : '---') . "'>
                  </div>
                  <div class='col-md-4 " . (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') . "'>
                     <label class='form-label pt-1'>Zaplaceno dne</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . (!empty($line['DatumZaplaceni']) ? date('d.m.Y H:i', strtotime($line['DatumZaplaceni'])) : '---') . "'>

                  </div>
                  <div class='col-md-3 " . (!empty($line['ZaplatiNaMiste']) ? 'd-none' : '') . "'>
                     <label class='form-label pt-1'>Částka (Kč)</label>
                     <input readonly class='bg-light text-dark form-control'  value='" . (!empty($line['Castka']) ? htmlspecialchars($line['Castka'], ENT_QUOTES, 'UTF-8') : '---') . "'>
                  </div>
               </div>
            </div>
         </div>
      </div>
</div>
		";
    } else {
        echo "<p class='text-danger'>Záznam nenalezen.</p>";
    }
}
