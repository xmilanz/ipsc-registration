<?php 
	$query = "SELECT * from match_config where Zavod_id='$table'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$match_configuration = mysql_fetch_array($result);

 if ($match_configuration[Payment_before]=="") {
   $paymentBeforeClass=" d-none";
 }
?>

<div class="modal fade" id="match_configuration" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header bg-success text-center">
        <h4 class="modal-title text-white w-100 font-weight-bold py-2">Konfigurace závodu</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
	  <!--Body-->
     <div class="modal-body">
		<form class="row needs-validation" method="post" action="./save.php?match_config" novalidate>

	<!--Accordion-->
 	<div id="accordion" class="col-md-12">

   <!-- accordion 1 Základní informace -->
    <div class="card">
    <a class="card-link" data-toggle="collapse" href="#collapseOne">
	  <div class="card-header font-weight-bolder ">Základní informace</div>
      </a>
     <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
			<div class="row">

 			<div class="col-md-8">
				<label for="Zavod" class="form-label pt-1">Název závodu</label>
				<input class="form-control" type="text" name="Zavod" id="Zavod" placeholder="název závodu" onfocus="this.placeholder = ''" onblur="this.placeholder = 'název závodu'" value="<?php echo $match_configuration['Zavod']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste název závodu</div>
			  </div>
		  
			<div class="col-md-4">
				<label for="Zavod_datum" class="form-label pt-1">Datum závodu</label>
				<input class="form-control" type="text" name="Zavod_datum" id="Zavod_datum" onkeypress="return avoidspace(event)" placeholder="datum závodu" onfocus="this.placeholder = ''" onblur="this.placeholder = '1.1.1970'" value="<?php echo $match_configuration['Zavod_datum']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste datum závodu</div>
			</div>

			<div class="col-md-12 ml-4 mt-2 ">
				<label class="form-check-label" for="Zavod_registrace_pozastaveno">
					<input type="checkbox" class="form-check-input" id="Zavod_registrace_pozastaveno" name="Zavod_registrace_pozastaveno" <?php if ( $match_configuration['Zavod_registrace_pozastaveno']=="on"){ echo "CHECKED";};?> ><span class="font-weight-bold text-danger">Pozastavit registraci</span>
				</label>
		  </div>

			<div class="col-md-12 py-2"></div>
			
			<div class="col-md-12">
				<label for="Zavod_poradatel" class="form-label pt-1">Pořadatel</label>
				<input class="form-control" type="text" name="Zavod_poradatel" id="Zavod_poradatel" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Klub praktické střelby EGGENBERG'" value="<?php echo $match_configuration['Zavod_poradatel']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste pořadatele</div>
			  </div>

			<div class="col-md-12 py-2"></div>

			<div class="col-md-5">
				<label for="Zavod_misto" class="form-label pt-1">Místo</label>
				<input class="form-control" type="text" name="Zavod_misto" id="Zavod_misto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'místo'" value="<?php echo $match_configuration['Zavod_misto']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste místo</div>
			  </div>
			<div class="col-md-7">
				<label for="Zavod_misto_mapa" class="form-label pt-1">Odkaz na mapy</label>
				<input class="form-control" type="text" name="Zavod_misto_mapa" id="Zavod_misto_mapa" onfocus="this.placeholder = ''" onblur="this.placeholder = 'odkaz na Google mapy nebo mapy.cz'" value="<?php echo $match_configuration['Zavod_misto_mapa']; ?>">
			</div>
        </div>
        </div>
      </div>
    </div>

   <!-- accordion 2 Nastavení závodu  -->
    <div class="card">
    <a class="card-link" data-toggle="collapse" href="#collapseTwo">
	  <div class="card-header font-weight-bolder ">Nastavení webových stránek a závodu</div>
      </a>
     <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">
			<div class="row">

			  <div class="col-md-5 mb-3  ml-3">
				<label class="form-check-label" for="Zavod_zobrazovat_sponzory">
					<input type="checkbox" class="form-check-input" id="Zavod_zobrazovat_sponzory" name="Zavod_zobrazovat_sponzory" <?php if ( $match_configuration['Zavod_zobrazovat_sponzory']=="on"){ echo "CHECKED";};?> >Zobrazovat sponzory</span>
				</label>
			</div>
				<div class="col-md-6 mb-3">
					<label class="form-check-label" for="Web_zobrazovat_situace">
						<input type="checkbox" class="form-check-input" id="Web_zobrazovat_situace" name="Web_zobrazovat_situace" <?php if ( $match_configuration['Web_zobrazovat_situace']=="on"){ echo "CHECKED";};?> ><span class="tooltip">Zobrazovat situace<span class="tooltiptext">Pokud nebudete v registraci zveřejňovat obrázky situací, odškrtněte volbu</span></span>
					</label>
			  </div>

			  <div class="col-md-5 mb-3  ml-3">
					<label class="form-check-label" for="Zavod_more_divisions">
						<input type="checkbox" class="form-check-input" id="Zavod_more_divisions" name="Zavod_more_divisions" <?php if ( $match_configuration['Zavod_more_divisions']=="on"){ echo "CHECKED";};?> ><span class="tooltip">Registrace do více divizí<span class="tooltiptext">Závodník se může zaregistrovat vícekrát bez nutnosti zadat jiné registrační údaje (alias, jméno a příjmení).<br><br>Do aliasu a příjmení se doplní zkratka divize (např. ALIAS-MR, PŘÍJMENÍ-MR</span></span>
					</label>
			  </div>

			  <div class="col-md-6 mb-3">
					<label class="form-check-label" for="Zavod_zbrojni_prukaz">
						<input type="checkbox" class="form-check-input" id="Zavod_zbrojni_prukaz" name="Zavod_zbrojni_prukaz" <?php if ( $match_configuration['Zavod_zbrojni_prukaz']=="on"){ echo "CHECKED";};?> >Evidovat ZP
					</label>
			  </div>

			<div class="col-md-12 py-2"></div>

 			<div class="col-md-4">
				<label for="Zavod_cas_registrace" class="form-label pt-1">Čas registrace</label>
				<input class="form-control" type="text" name="Zavod_cas_registrace" id="Zavod_cas_registrace" onkeypress="return avoidspace(event)" placeholder="formát 18:00:00" onfocus="this.placeholder = ''" onblur="this.placeholder = 'formát 17:00:00'" value="<?php echo $match_configuration['Zavod_cas_registrace']; ?>">
			  </div>
		  
 			<div class="col-md-4">
				<label for="Zavod_zacatek_registrace" class="form-label pt-1">Začátek registrace</label>
				<input class="form-control" type="text" name="Zavod_zacatek_registrace" id="Zavod_zacatek_registrace" onkeypress="return avoidspace(event)" placeholder="30 dní před závodem" onfocus="this.placeholder = ''" onblur="this.placeholder = '30 dní před závodem'" value="<?php echo $match_configuration['Zavod_zacatek_registrace']; ?>">
			  </div>
		  
 			<div class="col-md-4">
				<label for="Zavod_konec_registrace" class="form-label pt-1">Konec registrace</label>
				<input class="form-control" type="text" name="Zavod_konec_registrace" id="Zavod_konec_registrace" onkeypress="return avoidspace(event)" placeholder="3 dny před prematchem" onfocus="this.placeholder = ''" onblur="this.placeholder = '3 dny před prematchem'" value="<?php echo $match_configuration['Zavod_konec_registrace']; ?>">
			  </div>

			<div class="col-md-12 py-2"></div>

			<div class="col-md-4">
				<label for="Zavod_cas_prematch" class="form-label pt-1">Prematch</label>
				<input class="form-control" type="text" name="Zavod_cas_prematch" id="Zavod_cas_prematch" onfocus="this.placeholder = ''" onblur="this.placeholder = '12:00 - 16:00'" value="<?php echo $match_configuration['Zavod_cas_prematch']; ?>">
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_prezence" class="form-label pt-1">Prezence</label>
				<input class="form-control" type="text" name="Zavod_cas_prezence" id="Zavod_cas_prezence" onfocus="this.placeholder = ''" onblur="this.placeholder = '8:00 - 9:00'" value="<?php echo $match_configuration['Zavod_cas_prezence']; ?>">
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_main" class="form-label pt-1">Hlavní závod</label>
				<input class="form-control" type="text" name="Zavod_cas_main" id="Zavod_cas_main" onfocus="this.placeholder = ''" onblur="this.placeholder = '13:00 - 17:00'" value="<?php echo $match_configuration['Zavod_cas_main']; ?>">
			  </div>

			<div class="col-md-12 py-2"></div>

			<div class="col-md-4">
				<label for="Zavod_cas_main_dopoledne" class="form-label pt-1">Dopolední směna</label>
				<input class="form-control" type="text" name="Zavod_cas_main_dopoledne" id="Zavod_cas_prezence" onfocus="this.placeholder = ''" onblur="this.placeholder = '9:00 - 12:00'" value="<?php echo $match_configuration['Zavod_cas_main_dopoledne']; ?>">
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_main_odpoledne" class="form-label pt-1">Odpolední směna</label>
				<input class="form-control" type="text" name="Zavod_cas_main_odpoledne" id="Zavod_cas_main_odpoledne" onfocus="this.placeholder = ''" onblur="this.placeholder = '13:00 - 16:00'" value="<?php echo $match_configuration['Zavod_cas_main_odpoledne']; ?>">
			  </div>
			<div class="col-md-4">
				<label for="Zavod_cas_prematch" class="form-label pt-1"></label>
			  </div>
			  
			<div class="col-md-12 py-2"></div>			  
			  
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
					<input class="form-control" type="text" name="Squad_prem_max" id="Squad_prem_max" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Squad_prem_max']; ?>">
			</div>
			<div class="col-md-3">
					<label for="Squad_main_max" class="form-label pt-1">Squad</label>
					<input class="form-control" type="text" name="Squad_main_max" id="Squad_main_max" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Squad_main_max']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste počet závodníků ve squadu</div>
			</div>

        </div>
        </div>
      </div>
    </div>

	<!-- accordion 2 Vedení závodu -->
		<div class="card">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
			<div class="card-header font-weight-bolder ">Vedení závodu</div>
		</a>
		<div id="collapseThree" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
				<label for="Zavod_match_director" class="form-label pt-1">Match director</label>
				<input class="form-control" type="text" name="Zavod_match_director" id="Zavod_match_director" onfocus="this.placeholder = ''" onblur="this.placeholder = 'match director'" value="<?php echo $match_configuration['Zavod_match_director']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste match directora</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_range_master" class="form-label pt-1">Range master</label>
				<input class="form-control" type="text" name="Zavod_range_master" id="Zavod_misto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'range master'" value="<?php echo $match_configuration['Zavod_range_master']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste range mastera</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_stats" class="form-label pt-1">Statistik</label>
				<input class="form-control" type="text" name="Zavod_stats" id="Zavod_misto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'místo'" value="<?php echo $match_configuration['Zavod_stats']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste statistika</div>
			  </div>
			<div class="col-md-6">
				<label for="Zavod_hospodar" class="form-label pt-1">Hospodář</label>
				<input class="form-control" type="text" name="Zavod_hospodar" id="Zavod_hospodar" value="<?php echo $match_configuration['Zavod_hospodar']; ?>">
			  </div>
			</div>
			</div>
		</div>
		</div>
	
	<!-- accordion 3 Adresy a telefony -->
		<div class="card">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
			<div class="card-header font-weight-bolder ">Adresy a telefony</div>
		</a>
		<div id="collapseFour" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
				<label for="Klub_web" class="form-label pt-1">Webové stránky klubu</label>
					<input class="form-control" type="text" id="Klub_web" name="Klub_web" onfocus="this.placeholder = ''"  value="<?php echo $match_configuration['Klub_web']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste web klubu</div>
			</div>

			<div class="col-md-6">
				<label for="Zavod_vysledky" class="form-label pt-1">Stránka výsledků závodu</label>
					<input class="form-control" type="text" id="Zavod_vysledky" name="Zavod_vysledky" onfocus="this.placeholder = ''"  value="<?php echo $match_configuration['Zavod_vysledky']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste stránku výsledků závodu</div>
			</div>
			<div class="col-md-12 py-2"></div>

			<div class="col-md-6">
				<label for="Zavod_email_poradatel" class="form-label pt-1">Match Director</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="text" id="Zavod_email_poradatel" name="Zavod_email_poradatel" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''"  value="<?php echo $match_configuration['Zavod_email_poradatel']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste MD</div>
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_telefon_poradatel" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
				<input class="form-control" type="text" name="Zavod_telefon_poradatel" id="Zavod_telefon_poradatel" value="<?php echo $match_configuration['Zavod_telefon_poradatel']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste telefon</div>
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_email_range_master" class="form-label pt-1">Range Master</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="text" id="Zavod_email_range_master" name="Zavod_email_range_master" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''"  value="<?php echo $match_configuration['Zavod_email_range_master']; ?>">
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_telefon_range_master" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
				<input class="form-control" type="text" name="Zavod_telefon_range_master" id="Zavod_telefon_range_master" value="<?php echo $match_configuration['Zavod_telefon_range_master']; ?>">
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_email_stats" class="form-label pt-1">Statistik</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="text" id="Zavod_email_stats" name="Zavod_email_stats" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''"  value="<?php echo $match_configuration['Zavod_email_stats']; ?>">
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_telefon_stats" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
				<input class="form-control" type="text" name="Zavod_telefon_stats" id="Zavod_telefon_stats" value="<?php echo $match_configuration['Zavod_telefon_stats']; ?>">
				</div>
			</div>
			<div class="col-md-6">
				<label for="Zavod_email_hospodar" class="form-label pt-1">Hospodář</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="text" id="Zavod_email_hospodar" name="Zavod_email_hospodar" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_email_hospodar']; ?>">
				</div>
			</div>

			<div class="col-md-6">
					<label for="Zavod_telefon_hospodar" class="form-label pt-1">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="far fa-phone" style="font-size:13px"></i></div>
					</div>
					<input class="form-control" type="text" name="Zavod_telefon_hospodar" id="Zavod_telefon_hospodar" value="<?php echo $match_configuration['Zavod_telefon_hospodar']; ?>" >
				</div>
			</div>

			<div class="col-md-12 py-2"></div>

			<div class="col-md-7">
				<label for="Zavod_email_from" class="form-label pt-1">Odesílatel registračních emailů</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="Zavod_email_from" name="Zavod_email_from" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''"  placeholder="registrace@kps-eggenebrg.cz" value="<?php echo $match_configuration['Zavod_email_from']; ?>" required>
					<div class="invalid-feedback">Nevyplnili jste email</div>
				</div>
			</div>
			</div>
			</div>
		</div>
		</div>
	
	<!-- accordion 4 placení závodu -->
		<div class="card ">
		<a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
			<div class="card-header font-weight-bolder ">Placení závodu <span class="text-secondary small"><?php if ($match_configuration['Payment_before']=="on") {echo "(startovné se platí do " .$match_configuration['Zavod_pocet_dni_na_platbu'] ." dnů od registrace)";} else {echo "(startovné se platí na místě)";} ?> </span></div>
		</a>
		<div id="collapseFive" class="collapse" data-parent="#accordion">
			<div class="card-body">
			<div class="row">

			<div class="col-md-12 ml-4 mb-3 ">
				<label class="form-check-label" for="Payment_before">
					<input type="checkbox" class="form-check-input" id="Payment_before" name="Payment_before" <?php if ( $match_configuration['Payment_before']=="on"){ echo "CHECKED";};?> ><span class="font-weight-bold text-danger">Placení startovného <?php echo $match_configuration['Zavod_pocet_dni_na_platbu'];?> dnů od registrace</span>
				</label>
		  </div>


			<div class="col-md-4">
				<label for="Banka_ucet_CASTKA" class="form-label pt-1">Startovné (<?php echo $match_configuration['Banka_ucet_MENA']; ?>)</label>
				<input class="form-control" type="text" name="Banka_ucet_CASTKA" id="Banka_ucet_CASTKA" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_CASTKA']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste startovné</div>
			</div>
			<div class="col-md-4 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Banka_ucet_cislo" class="form-label pt-1">Číslo účtu</label>
				<input class="form-control" type="text" name="Banka_ucet_cislo" id="Banka_ucet_cislo" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_cislo']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste číslo účtu</div>
			</div>
			<div class="col-md-3 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Banka_ucet_kod" class="form-label pt-1">Kód banky</label>
				<input class="form-control" type="text" name="Banka_ucet_kod" id="Banka_ucet_kod" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Banka_ucet_kod']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste kód banky</div>
			</div>

			<div class="col-md-11 pt-2 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Banka_nazev" class="form-label pt-1">Banka</label>
				<input class="form-control" type="text" name="Banka_nazev" id="Banka_nazev" value="<?php echo $match_configuration['Banka_nazev']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste název banky</div>
			</div>

			<div class="col-md-11 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Banka_adresa" class="form-label pt-1">Adresa banky</label>
				<input class="form-control" type="text" name="Banka_adresa" id="Banka_adresa" value="<?php echo $match_configuration['Banka_adresa']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste adresu banky</div>
			</div>
			<div class="col-md-11 pt-1 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Zavod_poradatel_adresa" class="form-label pt-1">Adresa pořadatele</label>
				<input class="form-control" type="text" name="Zavod_poradatel_adresa" id="Zavod_poradatel_adresa" value="<?php echo $match_configuration['Zavod_poradatel_adresa']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste adresu banky</div>
			</div>

			<div class="col-md-5 pt-2 <?php echo "$paymentBeforeClass"; ?>">
				<label for="Zavod_pocet_dni_na_platbu" class="form-label pt-1">Počet dní na platbu</label>
				<input class="form-control" type="text" name="Zavod_pocet_dni_na_platbu" id="Zavod_pocet_dni_na_platbu" onkeypress="return avoidspace(event)" value="<?php echo $match_configuration['Zavod_pocet_dni_na_platbu']; ?>" required>
				<div class="invalid-feedback">Nevyplnili jste počet dní na platbu</div>
			</div>
			<div class="d-none col-md-5">
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
			<button type="button" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">Zavřít bez uložení</button>
		</div>
	 </form>
    </div>
	<!--/.Content-->
  </div>
  </div>

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


<script>
  $(document).ready(function(){
    $('#Zavod_datum').datepicker({
      format: 'dd.mm.yyyy',
      language: 'cs', // česká lokalizace
      autoclose: true
    });
  });
</script>
