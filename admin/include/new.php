<?php 
 if ($match_data[Payment_before]=="") {
   $paymentBeforeClass.=" d-none";
 }

 if ($match_configuration[Zavod_more_divisions]=="") {
   $zavodMoreDivisionsClass=" d-none";
 }

 if ($match_data[Zavod_zbrojni_prukaz]=="") {
   $zavodZbrojniPrukazClass=" d-none";
 }


?>
<div class="modal fade" id="new_shooter" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header bg-primary text-center">
        <h4 class="modal-title text-white w-100 font-weight-bold">Nový závodník</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>

      </div>
      <div class="modal-body">
		<form class="row needs-validation" method="post" action="./save.php?new_shooter"  novalidate>
			<?php
				list($usec, $sec) = explode(" ", microtime());
				echo "<INPUT TYPE=HIDDEN NAME=datreg VALUE=".$sec.">";
			?>
			<div class="col-md-8 font-weight-bolder">Osobní informace</div>


			<div class="col-md-6">
				<label for="Alias" class="form-label mt-2">Alias</label>
				<input pattern=".{3,16}" class="form-control" type="text" name="Alias" id="Alias" placeholder="3-16 znaků, bez diakritiky a spec. znaků" onfocus="this.placeholder = ''" onblur="replaceChars()" required>
				<label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
				<div class="invalid-feedback">Nevyplnili jste alias nebo má neplatnou délku</div>
			</div>

			<div class="col-md-6 <?php echo "$zavodZbrojniPrukazClass"; ?>">
				<label for="ZP" class="form-label mt-2">Zbrojní průkaz</label>
				<input class="form-control" type="text" name="ZP" id="ZP<?php echo"$i";?>" placeholder="číslo zbrojního průkazu" onfocus="this.placeholder = ''" onblur="this.placeholder = 'číslo zbrojního průkazu'" >
				<div class="invalid-feedback">Nevyplnili jste číslo zbrojního průkazu</div>
			  </div>

			<div class="<?php if ($match_data[Zavod_zbrojni_prukaz]=="on") {echo "col-md-0";} else {echo "col-md-12";}; ?>"></div>

			<div class="col-md-3">
				<label for="Jmeno" class="form-label mt-2">Jméno</label>
				<input class="form-control" type="text" name="Jmeno" id="Jmeno" placeholder="Jan" onfocus="this.placeholder = ''" onblur="Jan" onkeypress="return avoidspace(event)" required>
				<div class="invalid-feedback">Nevyplnili jste jméno</div>
			  </div>
			<div class="col-md-5">
				<label for="Prijmeni" class="form-label mt-2">Příjmení</label>
				<input class="form-control" type="text" name="Prijmeni" id="Prijmeni" placeholder="Novák" onfocus="this.placeholder = ''" onblur="Novák" onkeypress="return avoidspace(event)" required>
				<div class="invalid-feedback">Nevyplnili jste příjmení</div>
			  </div>
			<div class="col-md-4">
				<label for="Prijmeni_stav" class="form-label mt-2">Doplnění jména</label>
					<select class="form-control" name=Prijmeni_stav>
						<option value="" selected>--- vyberte ---</option>
						<option value=" ml.">ml.</option>
						<option value=" st.">st.</option>
					</select>
			</div>
			<div class="col-md-8">
				<label for="Mail" class="form-label mt-3">Email</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Mail" name="Mail" onfocus="this.placeholder = ''" onblur="replaceChars()" placeholder="novak@mujemail.cz" value="" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="Region" class="form-label mt-3">Region</label>
				<select name="Region" id="Region" class="custom-select" required>
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

			<div class="col-md-10 mt-4 font-weight-bolder">Závod</div>

			<div class="col-md-4">
				<label for="Squad" class="form-label mt-2">Squad</label>
				  <select class="form-control" name=Squad required>
					<option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_squads ORDER BY Number");
						while($squad = mysql_fetch_array($query))
						{
							echo "<option value=".$squad['Number'].">". $squad['Name']."</option>";
						}
					?>
				  </select>
			</div>

			<div class="col-md-4">
				<label for="Divize" class="form-label mt-2">Divize</label>
				  <select class="form-control" name="Divize" id="Divize" onchange="togglePidivMain()" required>
					<option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_divisions");
						while($division = mysql_fetch_array($query))
						{
							echo "<option value=".$division['Name'].">". $division['Value']."</option>";
						}
					?>
				  </select>
			</div>

			<div class="col-md-4 <?php echo "$zavodMoreDivisionsClass"; ?>">
				<label for="Divize_dalsi" class="form-label mt-2 mb-1 text-danger tooltip">Další divize <i class="fa fa-question-circle" aria-hidden="true"></i>
						<span class="tooltiptext">
						<span>Při registraci závodníka ve více divizích se postupuje tímto způsobem:
							<ul>
								<li>Při první registaci použijte první seznam divizí.</li>
								<li>Po dokončení registrace vyberte squad a vyplňte stejné údaje (Alias, Jméno, Příjmení, Email, Kategorie, Region).</li>
								<li>Další DIVIZI vyberte ze seznamu "Další divize"</li>
							</ul>
							<i>(jakmile se vybere jedna divize, není možné použít druhý seznam divizí)</i>
						</span>
					</span>
				</label>

					<select class="form-control" name="Divize_dalsi" id="Divize_dalsi" onchange="togglePidiv()">	
					<option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_divisions");
						while($division = mysql_fetch_array($query))
						{
							echo "<option value=".'-'.$division['Name'].">". $division['Value']."</option>";
						}
					?>
				  </select>
			</div>

			<div class="col-md-6">
				<label for="Kategorie" class="form-label mt-2">Kategorie</label>
				  <select class="form-control" name=Kategorie required>
					<option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_categories");
						while($category = mysql_fetch_array($query))
						{
							echo "<option value=".$category['Name'].">". $category['Name']."</option>";
						}
					?>
				  </select>
			</div>
			<div class="col-md-6">
				<label for="Faktor" class="form-label mt-2">Faktor</label>
					<select class="form-control" name=Faktor required>
						<option value="" selected>--- vyberte ---</option>
						<option value="MIN">Minor</option>
						<option value="MAJ">Major</option>
					</select>
			</div>
			<div class="col-md-12 mt-4 font-weight-bolder">Ostatní</div>
			<div class="col-md-6">
				<label for="Staff" class="form-label mt-2">Staff</label>
					<select class="form-control" name=Staff>
						<option value="" selected>--- vyberte ---</option>
						<option value="" >Platící závodník</option>
						<option value="RO">Rozhodčí</option>
						<option value="POM">Pomocník</option>
						<option value="VIP">VIP</option>
					</select>
			</div>

			<div class="col-md-6">
			 <div class=" <?php echo $paymentBeforeClass; ?>form-check form-check mt-5">
			   <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste">
			   <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
			 </div>
			</div>

			<div class="col-md-12">
				<label for="Poznamka" class="form-label mt-3">Poznámka</label>
				<input class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="">
			  </div>
			</div>
      <!--Footer-->
		<div class="modal-footer border-top-0">
			<button type="submit" class="btn btn-primary">Přidat závodníka</button>
			<button type="button" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">Zavřít bez uložení</button>
		</div>
	 </form>
    </div>
    <!--Content-->
  </div>
</div>
