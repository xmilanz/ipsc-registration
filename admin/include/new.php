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
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>

      </div>
      <div class="modal-body">
		<form class="row needs-validation" method="post" action="./save.php?new_shooter"  novalidate>
			<?php
				list($usec, $sec) = explode(" ", microtime());
				echo "<INPUT TYPE=HIDDEN NAME=datreg VALUE=".$sec.">";
			?>
			<INPUT TYPE=HIDDEN NAME=Region VALUE='CZE'>
			
			<div class="col-md-10 font-weight-bolder">Osobní informace</div>
			<div class="col-md-6">
				<label for="Alias" class="form-label pt-2">Alias</label>
				<input class="form-control" type="text" name="Alias" id="Alias" onkeypress="return avoidspace(event)" placeholder="ALIAS" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ALIAS'" value="" required>
				<div class="invalid-feedback">Nevyplnili jste alias</div>
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<label for="Jmeno" class="form-label pt-2">Jméno</label>
				<input class="form-control" type="text" name="Jmeno" id="Jmeno" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan'" value="" required>
				<div class="invalid-feedback">Nevyplnili jste jméno</div>
			  </div>
			<div class="col-md-6">
				<label for="Prijmeni" class="form-label pt-2">Příjmení</label>
				<input class="form-control" type="text" name="Prijmeni" id="Prijmeni" onkeypress="return avoidspace(event)" placeholder="Novák" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" value="" required>
				<div class="invalid-feedback">Nevyplnili jste příjemní</div>
			  </div>
			<div class="col-md-6">
				<label for="Prijmeni_stav" class="form-label pt-2">Doplnění jména</label>
					<select class="form-control" name=Prijmeni_stav>
						<option value="" selected>--- vyberte ---</option>
						<option value=" ml.">ml.</option>
						<option value=" st.">st.</option>
					</select>
			</div>
			<div class="col-md-6">
				<label for="Mail" class="form-label pt-2">Email</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Mail" name="Mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="" required>
				</div>
			</div>
			<div class="col-md-10 pt-4 font-weight-bolder">Závod</div>
			<div class="col-md-6">
				<label for="Pidiv" class="form-label pt-2">Divize</label>
				  <select class="form-control" name=Pidiv required>
					<option value="" selected>--- vyberte ---</option>
					<?php
					foreach( $zavod_divize as $divize => $popis ){
					echo "<option value='$divize'>$popis</option>"; 
					}
					?>
				  </select>
			</div>
			<div class="col-md-6">
				<label for="Pidiv" class="form-label pt-2">Kategorie</label>
				  <select class="form-control" name=Kategorie required>
					<option value="" selected>--- vyberte ---</option>
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
						<option value="" selected>--- vyberte ---</option>
						<option value="MIN">Minor - MIN</option>
						<option value="MAJ">Major - MAJ</option>
					</select>
			</div>
			<div class="col-md-6">
				<label for="Pidiv" class="form-label pt-2">Squad</label>
				  <select class="form-control" name=Squad required>
					<option value="" selected>--- vyberte ---</option>
					<?php
						foreach( $nazvy_squadu as $squad => $popis ){
						echo "<option value='$squad'>$popis</option>"; 
					}
					?>
				  </select>
			</div>
			<div class="col-md-10 pt-4 font-weight-bolder">Ostatní</div>
			<div class="col-md-12">
			 <div class="form-check form-check-inline">
			   <input class="form-check-input" type="checkbox" id="RO" name="RO">
			   <label class="form-check-label" for="RO">Rozhodčí</label>
			 </div>
			 <div class="form-check form-check-inline">
			   <input class="form-check-input" type="checkbox" id="POM" name="POM">
			   <label class="form-check-label" for="RO">Pomocník</label>
			 </div>
			 <div class="form-check form-check-inline">
			   <input class="form-check-input" type="checkbox" id="VIP" name="VIP">
			   <label class="form-check-label" for="RO">VIP</label>
			 </div>
			 <div class=" <?php echo $paymentBeforeClass; ?>form-check form-check pt-2">
			   <input class="form-check-input" type="checkbox" id="ZaplatiNaMiste" name="ZaplatiNaMiste">
			   <label class="form-check-label" for="ZaplatiNaMiste">Zaplatí na místě</label>
			 </div>
			 </div>
			<div class="col-md-12">
				<label for="Poznamka" class="form-label pt-3">Poznámka</label>
				<input class="form-control" type="text" name="Poznamka" id="Poznamka" onkeypress="return avoidspace(event)" placeholder="Poznámka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Poznámka'" value="">
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

<div class="text-left"><br>
	<div class="text-left"><a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#new_shooter">Přidat nového závodníka</a></div>
</div>
</div>
</div>
<br>

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>