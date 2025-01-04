<?php 
	$query = "SELECT * from match_config where Zavod_id='$table'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$match_configuration = mysql_fetch_array($result);

 if ($match_data[Payment_before]=="") {
   $paymentBeforeClass=" d-none";
 }
?>


<div class="modal fade" id="match_configuration" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header bg-success text-center">
        <h4 class="modal-title text-white w-100 font-weight-bold py-2">Konfigurace závodu</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
	  <!--Body-->
     <div class="modal-body">
		<form class="row needs-validation" method="post" action="./save.php?match_config" novalidate>

	<!--Accordion-->
 	<div id="accordion" class="col-md-12">

   <!-- accordion 1 -->
    <div class="card">
    <a class="card-link" data-toggle="collapse" href="#collapseOne">
	  <div class="card-header font-weight-bolder ">Základní informace</div>
      </a>
     <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
			<div class="row">
 			<div class="col-md-6">
				<label for="Zavod" class="form-label pt-1">Název závodu</label>
				<input class="form-control" type="text" name="Zavod" id="Zavod" onkeypress="return avoidspace(event)" placeholder="název závodu" onfocus="this.placeholder = ''" onblur="this.placeholder = 'název závodu'" value="<?php echo $match_configuration['Zavod']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste název závodu</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_datum" class="form-label pt-1">Datum závodu</label>
				<input class="form-control" type="text" name="Zavod_datum" id="Zavod_datum" onkeypress="return avoidspace(event)" placeholder="datum závodu" onfocus="this.placeholder = ''" onblur="this.placeholder = '1.1.1970'" value="<?php echo $match_configuration['Zavod_datum']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste datum závodu</div>
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_prematch" class="form-label pt-1">Prematch</label>
				<input class="form-control" type="text" name="Zavod_cas_prematch" id="Zavod_cas_prematch" onkeypress="return avoidspace(event)" placeholder="13:00 -17:00" onfocus="this.placeholder = ''" onblur="this.placeholder = '13:00 - 17:00'" value="<?php echo $match_configuration['Zavod_cas_prematch']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste čas prematche</div>
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_prezence" class="form-label pt-1">Prezence</label>
				<input class="form-control" type="text" name="Zavod_cas_prezence" id="Zavod_cas_prezence" onkeypress="return avoidspace(event)" placeholder="8:00 - 9:00" onfocus="this.placeholder = ''" onblur="this.placeholder = '13:00 - 17:00'" value="<?php echo $match_configuration['Zavod_cas_prezence']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste čas prezence</div>
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_main" class="form-label pt-1">Hlavní závod</label>
				<input class="form-control" type="text" name="Zavod_cas_main" id="Zavod_cas_main" onkeypress="return avoidspace(event)" placeholder="9:00 - 14:00" onfocus="this.placeholder = ''" onblur="this.placeholder = '13:00 - 17:00'" value="<?php echo $match_configuration['Zavod_cas_main']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste čas hlavního závodu</div>
			  </div>
			<div class="col-md-5">
				<label for="Zavod_misto" class="form-label pt-1">Místo</label>
				<input class="form-control" type="text" name="Zavod_misto" id="Zavod_misto" onkeypress="return avoidspace(event)" placeholder="místo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'místo'" value="<?php echo $match_configuration['Zavod_misto']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste místo</div>
			  </div>
			<div class="col-md-7">
				<label for="Zavod_poradatel" class="form-label pt-1">Pořadatel</label>
				<input class="form-control" type="text" name="Zavod_poradatel" id="Zavod_poradatel" onkeypress="return avoidspace(event)" placeholder="pořadatel závodu" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Klub praktické střelby EGGENBERG'" value="<?php echo $match_configuration['Zavod_poradatel']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste pořadatele</div>
			  </div>
			<div class="col-md-3">
				<label for="Zavod_min_pocet_ran" class="form-label pt-1">Počet ran</label>
				<input class="form-control" type="text" name="Zavod_min_pocet_ran" id="Zavod_min_pocet_ran" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_min_pocet_ran']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste počet ran</div>
			</div>
			<div class="col-md-3">
				<label for="Zavod_stages" class="form-label pt-1">Počet situací</label>
				<input class="form-control" type="text" name="Zavod_stages" id="Zavod_stages" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_stages']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste počet situací</div>
			</div>
			<div class="col-md-3">
					<label for="Squad_prem_max" class="form-label pt-1">Prematch</label>
					<input class="form-control" type="text" name="Squad_prem_max" id="Squad_prem_max" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Squad_prem_max']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste počet závodníků prematche</div>
			</div>
			<div class="col-md-3">
					<label for="Squad_main_max" class="form-label pt-1">Squad</label>
					<input class="form-control" type="text" name="Squad_main_max" id="Squad_main_max" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Squad_main_max']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste počet závodníků ve squadu</div>
			</div>
			<div class="col-md-4">
				<label for="Banka_ucet_CASTKA" class="form-label pt-1">Startovné (<?php echo $match_configuration['Banka_ucet_MENA']; ?>)</label>
				<input class="form-control" type="text" name="Banka_ucet_CASTKA" id="Banka_ucet_CASTKA" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_CASTKA']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste startovné</div>
			</div>

        </div>
        </div>
      </div>
    </div>


	<!-- accordion 2 -->
		<div class="card">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
			<div class="card-header font-weight-bolder ">Vedení závodu</div>
		</a>
		<div id="collapseTwo" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
				<label for="Zavod_match_director" class="form-label pt-1">Match director</label>
				<input class="form-control" type="text" name="Zavod_match_director" id="Zavod_match_director" onkeypress="return avoidspace(event)" placeholder="match director" onfocus="this.placeholder = ''" onblur="this.placeholder = 'match director'" value="<?php echo $match_configuration['Zavod_match_director']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste match directora</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_range_master" class="form-label pt-1">Range master</label>
				<input class="form-control" type="text" name="Zavod_range_master" id="Zavod_misto" onkeypress="return avoidspace(event)" placeholder="range master" onfocus="this.placeholder = ''" onblur="this.placeholder = 'range master'" value="<?php echo $match_configuration['Zavod_range_master']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste range mastera</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_stats" class="form-label pt-1">Statistik</label>
				<input class="form-control" type="text" name="Zavod_stats" id="Zavod_misto" onkeypress="return avoidspace(event)" placeholder="místo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'místo'" value="<?php echo $match_configuration['Zavod_stats']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste statistika</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_hospodar" class="form-label pt-1">Hospodář</label>
				<input class="form-control" type="text" name="Zavod_hospodar" id="Zavod_hospodar" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_hospodar']; ?>">
			  </div>
			</div>
			</div>
		</div>
		</div>
	
	<!-- accordion 3 -->
		<div class="card">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
			<div class="card-header font-weight-bolder ">Adresy a telefony</div>
		</a>
		<div id="collapseThree" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
				<label for="Klub_web" class="form-label pt-1">Webové stránky klubu</label>
					<input class="form-control" type="text" id="Klub_web" name="Klub_web" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?php echo $match_configuration['Klub_web']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste web klubu</div>
			</div>
			<div class="col-md-6">
					<label for="GDPR_spravce" class="form-label pt-1">GDPR správce</label>
					<input class="form-control" type="text" name="GDPR_spravce" id="Zavod_telefon" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['GDPR_spravce']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste GDPR správce</div>
			</div>
			<div class="col-md-12">
				<label for="Zavod_vysledky" class="form-label pt-1">Stránka výsledků závodu</label>
					<input class="form-control" type="text" id="Zavod_vysledky" name="Zavod_vysledky" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?php echo $match_configuration['Zavod_vysledky']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste web klubu</div>
			</div>

			<div class="col-md-6">
				<label for="Zavod_email_poradatel" class="form-label pt-1">Pořadatel</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Zavod_email_poradatel" name="Zavod_email_poradatel" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" value="<?php echo $match_configuration['Zavod_email_poradatel']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste pořadatele</div>
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_telefon_poradatel" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
				<input class="form-control" type="text" name="Zavod_telefon_poradatel" id="Zavod_telefon" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_telefon_poradatel']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste telefon</div>
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_email_hospodar" class="form-label pt-1">Hospodář</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="text" id="Zavod_email_hospodar" name="Zavod_email_hospodar" value="<?php echo $match_configuration['Zavod_email_hospodar']; ?>">
				</div>
			</div>

			<div class="col-md-6">
					<label for="Zavod_telefon_hospodar" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
					<input class="form-control" type="text" name="Zavod_telefon_hospodar" id="Zavod_telefon_hospodar" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_telefon_hospodar']; ?>" >
				</div>
			</div>
			<div class="col-md-7">
				<label for="Zavod_email_from" class="form-label pt-1">Odesílatel registračních emailů</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Zavod_email_from" name="Zavod_email_from" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="registrace@kps-eggenebrg.cz" value="<?php echo $match_configuration['Zavod_email_from']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste email</div>
				</div>
			</div>
			</div>
			</div>
		</div>
		</div>
	
	<!-- accordion 4 -->
		<div class="card <?php echo "$paymentBeforeClass"; ?>">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
			<div class="card-header font-weight-bolder ">Placení závodu</div>
		</a>
		<div id="collapseFour" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">

			<div class="col-md-5">
				<label for="Banka_ucet_cislo" class="form-label pt-1">Číslo účtu</label>
				<input class="form-control" type="text" name="Banka_ucet_cislo" id="Banka_ucet_cislo" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_cislo']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste číslo účtu</div>
			</div>
			<div class="col-md-4">
				<label for="Banka_ucet_kod" class="form-label pt-1">Kód banky</label>
				<input class="form-control" type="text" name="Banka_ucet_kod" id="Banka_ucet_kod" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_kod']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste kód banky</div>
			</div>
			<div class="col-md-5">
				<label for="Zavod_pocet_dni_na_platbu" class="form-label pt-1">Počet dní na platbu</label>
				<input class="form-control" type="text" name="Zavod_pocet_dni_na_platbu" id="Zavod_pocet_dni_na_platbu" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_pocet_dni_na_platbu']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste číslo účtu</div>
			</div>
			<div class="col-md-5">
				<label for="Zavod_pocet_dni_do_vyrazeni" class="form-label pt-1">Počet dní na vyřazení</label>
				<input class="form-control" type="text" name="Zavod_pocet_dni_do_vyrazeni" id="Zavod_pocet_dni_do_vyrazeni" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_pocet_dni_do_vyrazeni']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste kód banky</div>
			</div>
			</div>
		</div>
		</div>
	</div>
	<!--Accordion-->
      </div>
      </div>
	  <!--Body-->
      <!--Footer-->
		<div class="modal-footer border-top-0">
			<button type="submit" class="btn btn-success">Uložit konfiguraci závodu</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Zrušit</button>
		</div>
	 </form>
    </div>
	<!--/.Content-->
  </div>
  </div>
</div>


<div class="text-left"><br>
	<div class="text-left"><a href="" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#match_configuration">Konfigurace závodu</a></div>
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
