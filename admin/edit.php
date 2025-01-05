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

if ($match_data[Payment_before]=="") {
   $paymentBeforeClass.=" d-none";
}
?>
      <div class="modal-header bg-success text-center">
		<h4 class="modal-title text-white w-100 font-weight-bold">Úprava závodníka</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
	  </div>
      <div class="modal-body">
		<form class="row needs-validation mb-0" method="post" action="./save.php?edit_shooter" >
	  <!-- ID závodníka -->
		<INPUT type="hidden" id="shooterID" name="shooterID" value="<?php echo "$ID";?>" required>
	  <!-- ID závodníka -->
		<div class="col-md-10 font-weight-bolder">Osobní informace</div>
			<div class="col-md-6">
				<label for="Alias" class="form-label pt-2">Alias</label>
				<input class="form-control" type="text" name="Alias" id="Alias" onkeypress="return avoidspace(event)" placeholder="ALIAS" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ALIAS'" value="<?php echo "$line[Alias]";?>" required>
				<div class="invalid-feedback">Nevyplnili jste alias</div>
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-3">
				<label for="Jmeno" class="form-label pt-2">Jméno</label>
				<input class="form-control" type="text" name="Jmeno" id="Jmeno" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan'" value="<?php echo "$line[Jmeno]";?>" required>
				<div class="invalid-feedback">Nevyplnili jste jméno</div>
			  </div>
			<div class="col-md-5">
				<label for="Prijmeni" class="form-label pt-2">Příjmení</label>
				<input class="form-control" type="text" name="Prijmeni" id="Prijmeni" onkeypress="return avoidspace(event)" placeholder="Novák" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" value="<?php echo "$line[Prijmeni]";?>" required>
				<div class="invalid-feedback">Nevyplnili jste příjemní</div>
			  </div>
			<div class="col-md-4">
				<label for="Prijmeni_stav" class="form-label pt-2">Doplnění jména</label>
					<select class="form-control" name=Prijmeni_stav>
						<option value="" selected>--- vyberte ---</option>
						<option value=" ml.">ml.</option>
						<option value=" st.">st.</option>
					</select>
			</div>
			<div class="col-md-6">
				<label for="Mail" class="form-label pt-3">Email</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Mail" name="Mail" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?php echo "$line[Mail]";?>" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="Region" class="form-label pt-3">Region</label>
				<select name="Region" id="Region" class="custom-select" required>
                      <option value="<?php echo "$line[Region]";?>"><?php echo "$line[Region]";?></option>
					  <option value="AUT">Austria</option>
					  <option value="CZE">Czech Republic</option>
					  <option value="DEN">Denmark</option>
					  <option value="GER">Germany</option>
					  <option value="POL">Poland</option>
					  <option value="SUI">Switzerland</option>
					  <option value="SVK">Slovak Republic</option>
				</select>
				<div class="invalid-feedback">Nevybrali jste region</div>
			</div>

		<div class="col-md-10 pt-4 font-weight-bolder">Závod</div>
			<div class="col-md-6">
				<label for="Pidiv" class="form-label pt-2">Divize</label>
				  <select class="form-control" name=Pidiv required>
					<option value="<?php echo "$line[Pidiv]";?>"><?php echo "$line[Pidiv]";?></option>
					<?php
					foreach( $zavod_divize as $divize => $popis ){
					echo "<option value='$divize'>$popis</option>"; 
					}
					?>
				  </select>
			</div>
			<div class="col-md-6">
				<label for="Kategorie" class="form-label pt-2">Kategorie</label>
				  <select class="form-control" name=Kategorie required>
					<option value="<?php echo "$line[Kategorie]";?>"><?php echo "$line[Kategorie]";?></option>
					<?php
						foreach( $zavod_kategorie as $kategorie => $popis ){
						echo "<option value='$kategorie'>$popis</option>"; 
					}
					?>
				  </select>
			</div>
			<div class="col-md-6">
				<label for="Pifak" class="form-label pt-2">Faktor</label>
					<select class="form-control" name=Pifak required>
						<option value="<?php echo "$line[Pifak]";?>"><?php echo "$line[Pifak]";?></option>
						<option value="MIN">Minor - MIN</option>
						<option value="MAJ">Major - MAJ</option>
					</select>
			</div>
			<div class="col-md-6">
				<label for="Squad" class="form-label pt-2">Squad</label>
				  <select class="form-control" name=Squad required>
					<option value="<?php echo "$line[Squad]";?>"><?php echo "$line[Squad]";?></option>
					<?php
						foreach( $nazvy_squadu as $squad => $popis ){
						echo "<option value='$squad'>$popis</option>"; 
					}
					?>
				  </select>
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<label for="SquadReg" class="form-label pt-2">Squad před vyřazením</label>
					<input class="form-control" type="text" readonly class="form-control-plaintext" value="<?php echo "$line[SquadReg]";?>">
			</div>


	<div class="col-md-12 pt-4 font-weight-bolder">Ostatní</div>
			<div class="col-md-6">
				<label for="Staff" class="form-label pt-2">Staff</label>
					<select class="form-control" name=Staff>
						<option value="<?php echo "$line[Staff]";?>"><?php echo "$line[Staff]";?></option>
						<option value="">Platící závodník</option>
						<option value="RO">Rozhodčí</option>
						<option value="POM">Pomocník</option>
						<option value="VIP">VIP</option>
					</select>
			</div>

			<div class="col-md-6">
			 <div class=" <?php echo $paymentBeforeClass; ?>form-check form-check pt-5">
			   <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste" <?php if ( $line['ZaplatiNaMiste']=="on"){ echo "CHECKED";}; ?> >
			   <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
			 </div>
			</div>


			<div class="col-md-12">
				<label for="Poznamka" class="form-label pt-3">Poznámka</label>
				<input class="form-control" type="text" name="Poznamka" id="Poznamka" onkeypress="return avoidspace(event)" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="<?php echo "$line[Poznamka]";?>">
			 </div>

      <!--Footer-->
	<div class="modal-footer border-top-0 mt-3 col-12">
		<button type="submit" class="btn btn-success">Uložit závodníka</button>
		<button type="button" class="btn btn-default" onclick="window.location.href = 'index.php';">Zrušit</button>
	</div>
	 </form>
<script>
function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
</script>