<?php 
 if ($match_data[Payment_before]=="") {
   $paymentBeforeClass.=" d-none";
 }
?>
<div class="modal fade" id="new_shooter" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
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
			<div class="col-md-10 font-weight-bolder">Osobní informace</div>
			<div class="col-md-6">
				<label for="Alias" class="form-label pt-2">Alias</label>
				<input pattern=".{3,16}" class="form-control" type="text" name="Alias" id="Alias" placeholder="3-16 znaků, bez diakritiky a spec. znaků" onfocus="this.placeholder = ''" onblur="replaceChars()" required>
				<label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
				<div class="invalid-feedback">Nevyplnili jste alias nebo má neplatnou délku</div>
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-3">
				<label for="Jmeno" class="form-label pt-2">Jméno</label>
				<input class="form-control" type="text" name="Jmeno" id="Jmeno" placeholder="Jan" onfocus="this.placeholder = ''" onblur="Jan" onkeypress="return avoidspace(event)" required>
				<div class="invalid-feedback">Nevyplnili jste jméno</div>
			  </div>
			<div class="col-md-5">
				<label for="Prijmeni" class="form-label pt-2">Příjmení</label>
				<input class="form-control" type="text" name="Prijmeni" id="Prijmeni" placeholder="Novák" onfocus="this.placeholder = ''" onblur="Novák" onkeypress="return avoidspace(event)" required>
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
						<input class="form-control" type="email" id="Mail" name="Mail" onfocus="this.placeholder = ''" onblur="replaceChars()" placeholder="novak@mujemail.cz" value="" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="region" class="form-label pt-3">Region</label>
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

			<div class="col-md-10 pt-4 font-weight-bolder">Závod</div>
			<div class="col-md-6">
				<label for="Pidiv" class="form-label pt-2">Divize</label>
				  <select class="form-control" name=Pidiv required>
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
			<div class="col-md-6">
				<label for="Kategorie" class="form-label pt-2">Kategorie</label>
				  <select class="form-control" name=Kategorie required>
					<option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_categories");
						while($category = mysql_fetch_array($query))
						{
							echo "<option value=".$category['Name'].">". $category['Value']."</option>";
						}
					?>
				  </select>
			</div>
			<div class="col-md-6">
				<label for="Pifak" class="form-label pt-2">Faktor</label>
					<select class="form-control" name=Pifak required>
						<option value="" selected>--- vyberte ---</option>
						<option value="MIN">Minor - MIN</option>
						<option value="MAJ">Major - MAJ</option>
					</select>
			</div>
			<div class="col-md-6">
				<label for="Squad" class="form-label pt-2">Squad</label>
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
			<div class="col-md-12 pt-4 font-weight-bolder">Ostatní</div>
			<div class="col-md-6">
				<label for="Staff" class="form-label pt-2">Staff</label>
					<select class="form-control" name=Staff>
						<option value="" selected>--- vyberte ---</option>
						<option value="" >Platící závodník</option>
						<option value="RO">Rozhodčí</option>
						<option value="POM">Pomocník</option>
						<option value="VIP">VIP</option>
					</select>
			</div>

			<div class="col-md-6">
			 <div class=" <?php echo $paymentBeforeClass; ?>form-check form-check pt-5">
			   <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste">
			   <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
			 </div>
			</div>

			<div class="col-md-12">
				<label for="Poznamka" class="form-label pt-3">Poznámka</label>
				<input class="form-control" type="text" name="Poznamka" id="Poznamka" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="">
			  </div>
			</div>
      <!--Footer-->
		<div class="modal-footer border-top-0">
			<button type="submit" class="btn btn-primary">Přidat závodníka</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Zrušit</button>
		</div>
	 </form>
    </div>
    <!--/.Content-->
  </div>
</div>
	<a href="" class="btn btn-primary btn-rounded mr-3" data-toggle="modal" data-target="#new_shooter">Přidat nového závodníka</a>
</div>
</div>
<br>
