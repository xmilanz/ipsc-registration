<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once ("../config/data.php");

$ID=$_GET['ID'];
$query="SELECT * FROM ".$table." WHERE Cislo=$ID";
$res=mysql_query($query);
$line=mysql_fetch_array($res);

?>
<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once ("../config/data.php");

$ID=$_GET['ID'];
$query="SELECT * FROM ".$table." WHERE Cislo=$ID";
$res=mysql_query($query);
$line=mysql_fetch_array($res);
?>
      <div class="modal-header bg-warning text-center">
		<h4 class="modal-title text-white w-100 font-weight-bold">Informace o závodníkovi</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
	  </div>
      <div class="modal-body">
		<form class="row needs-validation" method="post" action="./save.php?match_config" novalidate>

	<!--Accordion-->
 	<div id="accordion" class="col-md-12">

   <!-- accordion 1 Základní informace -->
    <div class="card">
    <a class="card-link" data-toggle="collapse" href="#collapseOne">
	  <div class="card-header font-weight-bolder ">Osobní údaje</div>
      </a>
     <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
			<div class="row">
 			<div class="col-md-6">
				<label class="form-label pt-1">Jméno</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Jmeno']; ?>">
			  </div>
		  
			<div class="col-md-6">
				<label class="form-label pt-1">Příjmení</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Prijmeni']; ?>">
			</div>

			<div class="col-md-12 py-2"></div>

 			<div class="col-md-6">
				<label class="form-label pt-1">IPSC alias</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Alias']; ?>">
			  </div>
		  
			<div class="col-md-6">
				<label class="form-label pt-1">E-mail</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Mail']; ?>">
			</div>

			<div class="col-md-12 py-2"></div>

			<div class="col-md-12">
				<label class="form-label pt-1">Poznámka</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Poznamka']; ?>">
			</div>


        </div>
       </div>
     </div>
    </div>

	<!-- accordion 2 -->
		<div class="card">
		<a class="collapsed card-link <?php if ($line['Staff']!='')  {echo 'bg-success text-white';} ?>" data-toggle="collapse" href="#collapseTwo">
			<div class="card-header font-weight-bolder ">Závod</div>
		</a>
		<div id="collapseTwo" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-3">
				<label class="form-label pt-1">Číslo</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Cislo']; ?>">
			</div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Squad</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Squad']; ?>">
			  </div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Squad (reg)</label>
				<input readonly class="bg-light text-muted form-control"  value="<?php echo $line['SquadReg']; ?>">
			  </div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Staff</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Staff']; ?>">
			  </div>
			  
			<div class="col-md-12 py-2"></div>
		  
			<div class="col-md-3">
				<label class="form-label pt-1">Kategorie</label>
				<input readonly class="bg-light form-control"  value="<?php echo $line['Kategorie']; ?>">
			</div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Divize</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Pidiv']; ?>">
			  </div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Faktor</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Pifak']; ?>">
			  </div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Region</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Region']; ?>">
			  </div>
		  
        </div>
		</div>
		</div>
		</div>
	
	<!-- accordion 3 -->
		<div class="card">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
			<div class="card-header font-weight-bolder <?php if ($line['Vyrazeno']!='')  {echo 'bg-secondary text-white';} ?>">Registrace a vyřazení</div>
		</a>
		<div id="collapseThree" class="collapse" data-parent="#accordion">
			<div class="card-body">

			<div class="row">
			<div class="col-md-6">
				<label class="form-label pt-1">Datum registrace</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo gmdate("d.m.Y H:i", $line['DatReg']); ?>">
			</div>
 			<div class="col-md-6">
				<label class="form-label pt-1">IP registrace</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['RegistraceIP']; ?>">
			  </div>

			<div class="col-md-12 py-2"></div>
		  
			<div class="col-md-6">
				<label class="form-label pt-1">Datum a čas vyřazení</label>
				<input readonly class="bg-light form-control"  value="<?php if ($line['Vyrazeno']=='') {echo "";} else {echo date("d.m.Y", strtotime($line['Vyrazeno']));} ?>">
			</div>
 			<div class="col-md-6">
				<label class="form-label pt-1">IP vyřazení</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['VyrazenoIP']; ?>">
			  </div>

			</div>
			</div>
		</div>
		</div>
	
	<!-- accordion 4 placení závodu -->
		<div class="card <?php if (($line['ZaplatiNaMiste']=='on') OR ($line['Staff']=='RO') OR ($line['Staff']=='POM') OR ($line['Staff']=='VIP')) {echo 'd-none';} ?>">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
			<div class="card-header font-weight-bolder ">Placení</div>
		</a>
		<div id="collapseFour" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-3">
				<label class="form-label pt-1">Klíč</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['klic']; ?>">
			</div>
			<div class="col-md-3">
				<label class="form-label pt-1">VS</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['VarSym']; ?>">
			</div>
 			<div class="col-md-4">
				<label class="form-label pt-1">Zaplatit do</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php if ($line['ZaplatiNaMiste']=="on") {echo "na místě";} else {echo date("d.m.Y", strtotime($line['DatPay']));} ?>">
			  </div>


			<div class="col-md-12 py-2"></div>

 			<div class="col-md-4">
				<label class="form-label pt-1">Urgence</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Urgence']; ?>">
			  </div>
 			<div class="col-md-4">
				<label class="form-label pt-1">Zaplaceno</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php if ($line['ZaplatiNaMiste']=='on') {echo 'na místě';} elseif ($line['DatumZaplaceni']==NULL) {echo "";} else {echo date("d.m.Y", strtotime($line['DatumZaplaceni']));} ?>">
			  </div>
 			<div class="col-md-3">
				<label class="form-label pt-1">Částka (Kč)</label>
				<input readonly class="bg-light text-dark form-control"  value="<?php echo $line['Castka']; ?>">
			  </div>
		</div>
		</div>
	</div>
	<!--Accordion-->
      </div>
      </div>

      <!--Footer-->
	<div class="modal-footer border-top-0 mt-3 col-12">
		<button type="button" class="btn btn-default" onclick="window.location.href = 'index.php';">Zrušit</button>
	</div>
