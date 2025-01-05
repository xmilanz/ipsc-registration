<?php
include "./header.php"; 

$prematch_datum=date('Y-m-d', strtotime("-1 day", strtotime($match_data[Zavod_datum])));
$prematch_datum_human=date('j.n.Y', strtotime("-1 day", strtotime($match_data[Zavod_datum])));

if ($match_data[Zavod_cas_registrace]=="") {
  $match_data[Zavod_cas_registrace]="00:00:00";
}

// spusteni registrace $Zavod_zacatek_registrace dni pred hlavnim zavodem
$zavod_datum_zacatek_registrace=date('d.m.Y', strtotime("-$match_data[Zavod_zacatek_registrace] days", strtotime($match_data[Zavod_datum])));

$zavod_zacatek_registrace=date('Y-m-d', strtotime("$zavod_datum_zacatek_registrace"))." $match_data[Zavod_cas_registrace]";
$zavod_zacatek_registrace_time=date('Y-m-d', strtotime("$zavod_datum_zacatek_registrace"))." $match_data[Zavod_cas_registrace]";
$zavod_zacatek_registrace_human=date('j.n.Y', strtotime("$zavod_datum_zacatek_registrace"))." $match_data[Zavod_cas_registrace]";

// ukonceni registrace  $Zavod_konec_registrace dny pred hlavnim zavodem
$zavod_konec_registrace=date('Y-m-d', strtotime("-$match_data[Zavod_konec_registrace] days", strtotime($match_data[Zavod_datum])));
$zavod_konec_registrace_time=date('Y-m-d', strtotime("-$match_data[Zavod_konec_registrace] days", strtotime($match_data[Zavod_datum]))) ." $match_data[Zavod_cas_registrace]";
$zavod_konec_registrace_human=date('j.n.Y', strtotime("-$match_data[Zavod_konec_registrace] days", strtotime($match_data[Zavod_datum]))) ." $match_data[Zavod_cas_registrace]";

$reg_text="";
$reg_started=false;

if ($reg_started==false AND $match_data[Zavod_registrace_pozastaveno]=="on") {
  $reg_text="<H2 class='pb-3 text-danger'>Registrace je pozastavená</H2>";
  $match_data[Squad_main_max]=0;
  $match_data[Squad_prem_max]=0;
  $match_data[Zavod_datum]="-";
  $match_data[Zavod_cas_main]="-";
  $prematch_datum_human="-";
  $match_data[Zavod_cas_prematch]="-";
}

elseif ($dnes < $zavod_zacatek_registrace_time) {
  $reg_text="<H2 class='pb-3'>Registrace bude spuštěna $zavod_zacatek_registrace_human</H2>";
  $match_data[Squad_main_max]=0;
  $match_data[Squad_prem_max]=0;
}

elseif ($dnes > $zavod_konec_registrace_time) {
  $reg_started=true;
  $reg_text="<H2 class='pb-3'>Registrace byla ukončena $zavod_konec_registrace_human</H2>";
  $match_data[Squad_main_max]=0;
  $match_data[Squad_prem_max]=0;
}

 else {
  $reg_started=true;
  $reg_text="<H2 class='pb-3'>Registrace bude ukončena $zavod_konec_registrace_human</H2>";
}  

echo"$reg_text";

 $query = "SELECT * FROM $table_squads";
 $result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Uložení výsledků do asociativního pole
$nazvy_squadu = [];
while ($row = mysql_fetch_assoc($result)) {
    $nazvy_squadu[$row['Number']] = $row['Name'];
}

// Iterace přes hodnoty od -2 do 211
for ($i = -2; $i <= 211; $i++) {
    if (isset($nazvy_squadu[$i])) {
        $nazev_squadu = $nazvy_squadu[$i];

    ######################
//    if ($i==100 AND $match_data[Squad_prem_max]>0) {echo "<H4>Prematch - $prematch_datum_human ($match_data[Zavod_cas_prematch])</h4>";};
    if ($i==100) {echo "<H4>Prematch $prematch_datum_human ($match_data[Zavod_cas_prematch])</h4>";};
    if ($i==101 AND $match_data[Zavod_cas_main]!=='' AND $match_data[Zavod_cas_main_odpoledne]=='') {echo "<H4>Hlavní závod $match_data[Zavod_datum] ($match_data[Zavod_cas_main])</h4>";};
    if ($i==101 AND ($match_data[Zavod_cas_main_dopoledne]!=='' OR $match_data[Zavod_cas_main_odpoledne]!=='')) {echo "<H4>Hlavní závod - dopolední směna - $match_data[Zavod_datum] ($match_data[Zavod_cas_main_dopoledne])</h4>";};
    if ($i==201 AND ($match_data[Zavod_cas_main_dopoledne]!=='' OR $match_data[Zavod_cas_main_odpoledne]!=='')) {echo "<H4>Hlavní závod - odpolední směna - $match_data[Zavod_datum] ($match_data[Zavod_cas_main_odpoledne])</h4>";};
    #######################
?>

<div class="row my-3 mx-1 ml-2 border border-primary bg-white clearfix">
	<!-- název squadu + počty -->
	<div class="col h5 font-weight-bolder jumbotron">
	
	<?php
		echo "$nazev_squadu";
		// zjisteni poctu zavodniku ve squadu
		$query = "SELECT Count(Prijmeni) FROM ".$table." WHERE Squad='".$i."'";
		$result =  mysql_query($query) or die('Query failed: ' . mysql_error());
		$line = mysql_fetch_row($result);
		if ($i<=0) {
		echo "";
		} else {
		  if ($i>100 AND $i<211) {
			echo "&nbsp<small>[obsazenost: ".$line[0]."/".($match_data[Squad_main_max])."]</small>";
		  }
		}
	?>
	<!-- tlačítko registrace -->
	<?php
// spustena registrace
		if ( 
				((($dnes > $zavod_zacatek_registrace_time) AND ($dnes < $zavod_konec_registrace_time)) AND ( ($line[0] < $match_data[Squad_main_max] AND $i >100)) ) 
			XOR
				((($dnes > $zavod_zacatek_registrace_time) AND ($dnes < $zavod_konec_registrace_time)) AND (($line[0] < $match_data[Squad_prem_max] AND $i <=100)) ) 
			)
		{
			echo "<button type='button' class='btn btn-primary float-right' data-toggle='collapse' href='#reg_form_$i'>Vybrat</button>";
		}
// spustena registrace (plny squad)
		if (
				((($dnes > $zavod_zacatek_registrace_time) AND ($dnes < $zavod_konec_registrace_time)) AND (($line[0] >= $match_data[Squad_main_max] AND $i >100 )) )
			XOR 
				((($dnes > $zavod_zacatek_registrace_time) AND ($dnes < $zavod_konec_registrace_time)) AND (($line[0] >= $match_data[Squad_prem_max] AND $i <=100 )) )
			) 
		{
			echo "<button type='button' class='btn btn-danger float-right' disabled>Obsazeno</button>";
		}
// registrace nezacala
		else
		{
		  echo "";
		}
	?>
	</div>

	<!-- seznam závodníků -->
	<div class="col-12 d-block pb-3 text-left">
	<?php
	#### - zobrazeni jmen v konkretnim squadu
		if ($reg_started==true) {
		  $query = "SELECT alias,Prijmeni,Jmeno,Zaplaceno,DatumZaplaceni,ZaplatiNaMiste,DatPay,Pidiv,Pifak,Staff,Squad,Urgence FROM ".$table." WHERE Squad='".$i."' ORDER BY Zaplaceno DESC,Prijmeni";
		  $result =  mysql_query($query) or die('Query failed: ' . mysql_error());
		  while ($line = mysql_fetch_array($result)) {

			if (($line[Zaplaceno]=="on") and ($match_data[Payment_before]=="on")) {echo "<span class=text-success>";};
			if (($dnes >= date('Y-m-d', strtotime($line[DatPay]. ' - 5 days')))  and $line[Squad]>=100 and $line[Zaplaceno]!="on" and $line[ZaplatiNaMiste]!="on" ) {echo "<span class= text-danger>";};

		// definice ikon 
			$serieIcon="";
			$roIcon="";
				if ($line[Staff]=="RO") {$roIcon="<i class='far fa-clock' style='font-size:12px'></i>";};
			$pomIcon="";
				if ($line[Staff]=="POM") {$pomIcon="<i class='far fa-handshake' style='font-size:12px'></i>";};
			$vipIcon="";
				if ($line[Staff]=="VIP") {$vipIcon="<i class='far fa-crown' style='font-size:12px'></i>";};

			echo "<span class='font-weight-bold text-nowrap'>".$serieIcon.$roIcon.$pomIcon.$vipIcon."&nbsp;$line[Jmeno]&nbsp;$line[Prijmeni]</span>&nbsp;<span class=\"font-weight-light\">'$line[alias]'</span></span>,  ";
			};
		}
		#### - konec zobrazeni jmen v konkretnim squadu
	?>
	</div>

<!-- registrační formulář -->
	<div class="col bg-light m-3 border rounded border-primary">
		<div id="reg_form_<?php echo"$i";?>" class="collapse">
			<form class="row my-3 needs-validation" method="post" action="./registrovat.php" novalidate>
			<?php 
			$query = "SELECT Max(Cislo) FROM ".$table."";
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
			$line = mysql_fetch_row($result);

			$tyden=str_replace(' ','',$match_data[Zavod_datum]);
			$tyden=intval(date("W",strtotime($tyden)));

			$varsymbol="$tyden".($line[0]+1);

			list($usec, $sec) = explode(" ", microtime());

			echo "<input type=hidden name=varsymbol value=".$varsymbol.">";
			echo "<input type=hidden name=datreg value=".$sec.">";
			echo "<input type=hidden name=squad value=".$i.">";
			?>

			<div class="col-md-5">
				<div class="form">
				  <label for="alias" class="form-label font-weight-bold">Alias&nbsp;&nbsp;<a href="https://www.ipsc-tech.org/ics/hq/embdAliasAvail.aspx"  target="_blank"  data-toggle="tooltip" title="Ověřte, zda není zadávaný alias již registrovaný."><button type="button" class="btn btn-outline-success btn-sm">Ověřit</button></a>&nbsp;&nbsp;<a href="https://www.ipsc-tech.org/ics/hq/embdAliasReg.aspx" target="_blank" data-toggle="tooltip" title="Pokud ještě nemáte alias, zaregistrujte si jej."><button type="button" class="btn btn-outline-primary btn-sm">Vytvořit</button></a></label>
				  <input pattern=".{3,16}" class="form-control" type="text" name="alias" id="alias<?php echo"$i";?>" placeholder="3-16 znaků, diakritiky a spec. znaků" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="replaceChars()" required>
				  <label class="alias_validation" data-error="Použili jste písmena s diakritikou nebo speciální znaky"></label>
				  <div class="invalid-feedback">Nevyplnili jste IPSC alias nebo má neplatnou délku (3-16 znaků)</div>
				</div>
			</div>
			<div class="col-7"></div>

			<div class="col-md-3">
				<label for="jmeno" class="form-label pt-3">Jméno</label>
				<input class="form-control" type="text" name="jmeno" id="jmeno<?php echo"$i";?>" onkeypress="return avoidspace(event)" placeholder="Jan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jan'" required>
				<div class="invalid-feedback">Nevyplnili jste jméno</div>
			  </div>
			  <div class="col-md-3">
				<label class="form-label pt-3">Příjmení</label>
				<input class="form-control" type="text" name="prijmeni" id="prijmeni<?php echo"$i";?>" onkeypress="return avoidspace(event)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" placeholder="Novák" required>
				<div class="invalid-feedback">Nevyplnili jste příjmení</div>
			  </div>
			  <div class="col-md-2">
				<label class="form-label pt-3">Doplnění jména</label>
				<select name="prijmeni_stav" id="prijmeni_stav<?php echo"$i";?>" class="custom-select">
					<option value="" selected>-</option>
					<option value=" ml.">ml.</option>
					<option value=" st.">st.</option>
				</select>
			  </div>
			<div class="col-md-4">
				<label for="email" class="form-label pt-3">Email</label>
				<div class="input-group">
					<div class="input-group-prepend">
					<div class="input-group-text">@</div>
					</div>
						<input class="form-control" type="email" id="email<?php echo"$i";?>" name="email" onfocus="this.placeholder = ''" onkeypress="return avoidspace(event)" placeholder="novak@mujemail.cz" onblur="replaceChars()" required>
				</div>
				<div class="invalid-feedback">Nevyplnili jste email</div>
			</div>
	 
			<div class="col-md-2">
				<label for="kategorie" class="form-label pt-3">Kategorie</label>
				<select name="kategorie" id="kategorie<?php echo"$i";?>" class="custom-select" required>
					<option value="Regular" selected>Regular</option>
					<?php
					$query = mysql_query("SELECT * from $table_categories");
						while($category = mysql_fetch_array($query))
						{
							echo "<option value=".$category['Name'].">". $category['Name']."</option>";
						}
					?>
				</select>
				<div class="invalid-feedback">Nevybrali jste kategorii</div>
			</div>

			<div class="col-md-2">
				<label for="divize" class="form-label pt-3">Divize</label>
				<select name ="pidiv" id="divize<?php echo"$i";?>" class="custom-select" required>
				  <option value="" selected>--- vyberte ---</option>
					<?php
					$query = mysql_query("SELECT * from $table_divisions");
						while($division = mysql_fetch_array($query))
						{
							echo "<option value=".$division['Name'].">". $division['Value']."</option>";
						}
					?>
				</select>
				<div class="invalid-feedback">Nevybrali jste divizi</div>
			  </div>

			<div class="col-md-2">
				<label for="faktor" class="form-label pt-3">Faktor</label>
				<select name="pifak" id="faktor<?php echo"$i";?>" class="custom-select" required>
				  <option value="MIN" selected>Minor</option>
					  <option value="MIN">Minor</option>
					  <option value="MAJ">Major</option>
				</select>
				<div class="invalid-feedback">Nevybrali jste faktor</div>
			</div>

			<div class="col-md-2">
				<label for="region" class="form-label pt-3">Region</label>
				<select name="region" id="faktor<?php echo"$i";?>" class="custom-select" required>
					  <option value="AUS">Austria</option>
					  <option value="CZE" selected>Czech Republic</option>
					  <option value="GER">Germany</option>
					  <option value="POL">Poland</option>
					  <option value="SVK">Slovak Republic</option>
				</select>
				<div class="invalid-feedback">Nevybrali jste region</div>
			</div>

			<div class="col-md-2">
				<label for="Staff" class="form-label pt-3">Staff</label>
					<select class="form-control" name=Staff>
						<option value="" selected>--- vyberte ---</option>
						<option value="RO">Rozhodčí</option>
						<option value="POM">Pomocník</option>
					</select>
			</div>

			<div class="col-12 pt-4">
				<div class="custom-control custom-checkbox">
				  <input class="custom-control-input" type="checkbox" id="souhlas<?php echo"$i";?>" required>
				  <label class="custom-control-label" for="souhlas<?php echo"$i";?>">
					Souhlasím s <span style="cursor: pointer; text-decoration: underline !important;" id="pravidla_registrace<?php echo "$i";?>">pravidly registrace</span> a zpracováním osobních údajů.
				  </label>
				</div>
			</div>

			<!-- toast - pravidla -->
			<div class="position-absolute d-flex">
			  <div class="toast hide">
					<div class="toast-header border-bottom bg-primary">
					  <strong class="mr-auto text-white font-weight-bolder">Pravidla registrace a úhrady startovaného</strong>
					  <button type="button" class="ml-2 mb-1 text-white close" data-dismiss="toast">×</button>
				  </div>
					<div class="toast-body ml-1">
						<p>V souladu s pravidlem 6.6.2 je účast v prematchi omezena na organizátory, rozhodčí, pomocníky a sponzory.</p>
						<p>Rozhodčí se registrují po dohodě s RM.</p>
						<p>Registrace se uzavírá 3 dny před konáním hlavního závodu.</p>
						<p>Pořadatelé si vyhrazují právo dodatečně měnit zařazení závodníků do squadů dle potřeb hladkého průběhu závodu.</p>
						<p>Změny v registraci (např. náhrada závodníka při přenosu startovného) lze provést nejpozději v den prematche.</p>
						<p>Přesuny závodníků mezi squady na základě jejich žádosti lze provést <b>nejpozději do 30 minut před oficiálním zahájením hlavního závodu.</b></p>
						<p class="text-danger font-weight-bold">Protože jsou podklady pro zaplacení startovaného posílány emailem, zbavuje se závodník při zadání neplatné emailové adresy možnosti zúčastnit se závodu. Rovněž nebude moci být informován o případných změnách.</p>
						<p class="<?php echo "$paymentBeforeClass"; ?> ">Startovné se hradí tak, aby platba proběhla do <?php echo $match_data['Zavod_pocet_dni_na_platbu']; ?> dnů od registrace.<br>- u závodníků zaregistrovaných méně jak <?php echo $match_data['Zavod_pocet_dni_na_platbu']; ?> dní před závodem je třeba startovné zaplatit <strong>nejpozději jeden den před prematchem</strong></p>
						<p class="<?php echo "$paymentBeforeClass"; ?> ">V případě neuhrazení startovného v řádném termínu je registrace zrušena.<br>- neplatí pro organizátory, pomocníky a rozhodčí</p>
					</div>
			  </div>
			</div>
			<!-- toast - pravidla -->

			  <div class="col-12 text-center">
				<button type="submit" class="btn btn-primary">Registrovat</button>
			  </div>
			</form>
		</div>
	</div>
<!-- registrační formulář -->
</div>

<?php
};
};
?>
<pre>
- rozhodčí <i class='far fa-clock' style='font-size:14px'></i>
- pomocník <i class='far fa-handshake' style='font-size:14px'></i>
- VIP <i class='far fa-crown' style='font-size:12px'></i>
<span class="<?php echo "$paymentBeforeClass"; ?> text-success">- zaplaceno nebo potvrzeno pořadatelem (pomocníci a rozhodčí)</span>
<span class="<?php echo "$paymentBeforeClass"; ?> text-danger">- zbývá méně jak 5 dní do zaplacení</span>
</pre>

<script type="text/javascript" src="./js/reg_form.js"></script>


<?php include "./footer.php"; ?>
