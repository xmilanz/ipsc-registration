<?php
include "./header.php"; 

$dnes=date_format(new DateTime(),"Y-m-d H:i:s");
$prematch_datum=date('j.n.Y', strtotime("-1 day", strtotime($match_data[Zavod_datum])));

// spusteni registrace 30 dni pred hlavnim zavodem (konfigurace v data.php)
$zavod_datum_zacatek_registrace=date('d.m.Y', strtotime("-$zavod_limit_zacatek_registrace days", strtotime($match_data[Zavod_datum])));

// ukonceni registrace 3 dny pred hlavnim zavodem (konfigurace v data.php)
$zavod_konec_registrace=date('Y-m-d H:i:s', strtotime("-$zavod_limit_konec_registrace days", strtotime($match_data[Zavod_datum])));
$zavod_konec_registrace_h=date('j.n.Y H:i:s', strtotime("-$zavod_limit_konec_registrace days", strtotime($match_data[Zavod_datum])));

if (!isset($zavod_cas_zacatek_registrace)) {
  $zavod_cas_zacatek_registrace="00:00:00";
}

$reg_text="";
$zavod_zacatek_registrace=date('Y-m-d', strtotime("$zavod_datum_zacatek_registrace"))." $zavod_cas_zacatek_registrace";
$zavod_zacatek_registrace_h=date('j.n.Y', strtotime("$zavod_datum_zacatek_registrace"))." $zavod_cas_zacatek_registrace";
$reg_started=false;

// echo "dnes: $dnes<br><br>";
// echo "zacatek registrace: $zavod_zacatek_registrace<br>";
// echo "konec registrace: $zavod_konec_registrace<br><br>";

if ($dnes < $zavod_zacatek_registrace) {
  $reg_text="Registrace bude spuštěna $zavod_zacatek_registrace_h";
  $match_data[Squad_main_max]=0;
  $match_data[Squad_prem_max]=0;
}

elseif ($dnes > $zavod_konec_registrace) {
  $reg_started=true;
  $reg_text="Registrace byla ukončena $zavod_konec_registrace_h";
  $match_data[Squad_main_max]=0;
  $match_data[Squad_prem_max]=0;
}

 else {
  $reg_started=true;
  $reg_text="Registrace bude ukončena $zavod_konec_registrace_h";
}  

echo"<H2 class='pb-3'>$reg_text</H2>";

for ($i = -2; $i <= $match_data[Zavod_stages]; $i++) {
    if (!$nazvy_squadu[$i]) {
      continue;
    }
    $nazev_squadu=$nazvy_squadu[$i]; 

    ######################
    if ($i==0) {echo "<H4>Prematch - $prematch_datum ($match_data[Zavod_cas_prematch])</h4>";};
    if ($i==1) {echo "<H4>Hlavní závod - $match_data[Zavod_datum] ($match_data[Zavod_cas_main])</h4>";};
    #######################
?>

<div class="row my-3 mx-1 border border-primary bg-white clearfix">
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
		  if ($i<111) {
			echo "&nbsp<small>[obsazenost: ".$line[0]."/".($match_data[Squad_main_max])."]</small>";
		  }
		}
	?>
	<!-- tlačítko registrace -->
	<?php
// spustena registrace
		if ( 
				((($dnes > $zavod_zacatek_registrace) AND ($dnes < $zavod_konec_registrace)) AND ( ($line[0] < $match_data[Squad_main_max] AND $i >0)) ) 
			XOR
				((($dnes > $zavod_zacatek_registrace) AND ($dnes < $zavod_konec_registrace)) AND (($line[0] < $match_data[Squad_prem_max] AND $i <=0)) ) 
			)
		{
			echo "<button type='button' class='btn btn-primary float-right' data-toggle='collapse' href='#reg_form_$i'>Vybrat</button>";
		}
// spustena registrace (plny squad)
		if (
				((($dnes > $zavod_zacatek_registrace) AND ($dnes < $zavod_konec_registrace)) AND (($line[0] >= $match_data[Squad_main_max] AND $i > 0)) )
			XOR 
				((($dnes > $zavod_zacatek_registrace) AND ($dnes < $zavod_konec_registrace)) AND (($line[0] >= $match_data[Squad_prem_max] AND $i <= 0)) )
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
		  $query = "SELECT alias,Prijmeni,Jmeno,Zaplaceno,DatumZaplaceni,DatReg,Pidiv,Pifak,RO,POM,VIP,Squad,Urgence FROM ".$table." WHERE Squad='".$i."' ORDER BY Zaplaceno DESC,Prijmeni";
		  $result =  mysql_query($query) or die('Query failed: ' . mysql_error());
		  while ($line = mysql_fetch_array($result)) {

			$DatReg=date('Y-m-d', $line["DatReg"]);
			$RegLimit=date('Y-m-d', strtotime($DatReg .+$match_data[Zavod_pocet_dni_na_platbu].' days'));
			$CancelLimit=date('Y-m-d', strtotime($DatReg. +$match_data[Zavod_pocet_dni_do_vyrazeni].' days'));

			if (($line[Zaplaceno]=="on") and ($match_data[Payment_before]=="on")) {echo "<span class=text-success>";};
			if (($dnes >= $RegLimit) and $line[Zaplaceno]!="on" and $line[Urgence]="on") {echo "<span class= text-danger>";};
			$zbran=$line[Pidiv];
			$zbranFactor="";
			if ($line[Pifak]=="MAJ") {
			$zbranFactor="+";
			}
		// definice ikon 
			$serieIcon="";
			$roIcon="";
				if ($line[RO]=="on") {$roIcon="<i class='far fa-clock' style='font-size:12px'></i>";};
			$pomIcon="";
				if ($line[POM]=="on") {$pomIcon="<i class='far fa-handshake' style='font-size:12px'></i>";};
			$vipIcon="";
				if ($line[VIP]=="on") {$vipIcon="<i class='far fa-crown' style='font-size:12px'></i>";};

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
			$varsymbol="$tyden".($line[0]+1); //prefix "18" pro var.symbol pistole.
			list($usec, $sec) = explode(" ", microtime());

			echo "<input type=hidden name=varsymbol value=".$varsymbol.">";
			echo "<input type=hidden name=datreg value=".$sec.">";
			echo "<input type=hidden name=squad value=".$i.">";
			?>
			<input type="hidden" name="region" value="CZE">

			<div class="col-md-5">
				<div class="form">
				  <label for="alias" class="form-label font-weight-bold">Alias&nbsp;&nbsp;<a href="https://www.ipsc-tech.org/ics/hq/embdAliasAvail.aspx"  target="_blank"  data-toggle="tooltip" title="Ověřte, zda není zadávaný alias již registrovaný."><button type="button" class="btn btn-outline-success btn-sm">Ověřit</button></a>&nbsp;&nbsp;<a href="https://www.ipsc-tech.org/ics/hq/embdAliasReg.aspx" target="_blank" data-toggle="tooltip" title="Pokud ještě nemáte alias, zaregistrujte si jej."><button type="button" class="btn btn-outline-primary btn-sm">Vytvořit</button></a></label>
				  <input pattern=".{3,16}" class="form-control" type="text" name="alias" id="alias<?php echo"$i";?>" placeholder="3-16 znaků, bez mezer, diakritiky a spec. znaků" onfocus="this.placeholder = ''" onblur="this.placeholder = '3-16 znaků, bez mezer, diakritiky a spec. znaků'" required>
				  <label class="alias_validation" data-error="Použili jste mezeru, písmena s diakritikou nebo speciální znaky"></label>
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
				<input class="form-control" type="text" name="prijmeni" id="prijmeni<?php echo"$i";?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Novák'" placeholder="Novák" required>
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
						<input class="form-control" type="email" id="email<?php echo"$i";?>" name="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'novak@mujemail.cz'" placeholder="novak@mujemail.cz" required>
				</div>
				<div class="invalid-feedback">Nevyplnili jste email</div>
			</div>
	 
			<div class="col-md-4">
				<label for="kategorie" class="form-label pt-3">Kategorie</label>
				<select name="kategorie" id="kategorie<?php echo"$i";?>" class="custom-select" required>
					<option value="" selected>--vyberte--</option>
					<?php
					  foreach( $zavod_kategorie as $kategorie => $popis ){
					  echo "<option value='$kategorie'>$popis</option>"; 
					  }
					?>
				</select>
				<div class="invalid-feedback">Nevybrali jste kategorii</div>
			</div>
			 
			<div class="col-md-4">
				<label for="divize" class="form-label pt-3">Divize</label>
				<select name ="pidiv" id="divize<?php echo"$i";?>" class="custom-select" required>
				  <option value="" selected>--- vyberte ---</option>
					<?php
					  foreach( $zavod_divize as $divize => $popis ){
					  echo "<option value='$divize'>$popis</option>"; 
					  }
					?>
				</select>
				<div class="invalid-feedback">Nevybrali jste divizi</div>
			  </div>
			 
			<div class="col-md-4">
				<label for="faktor" class="form-label pt-3">Faktor</label>
				<select name="pifak" id="faktor<?php echo"$i";?>" class="custom-select" required>
				  <option value="" selected>--- vyberte ---</option>
					  <option value="MIN">Minor</option>
					  <option value="MAJ">Major</option>
				</select>
				<div class="invalid-feedback">Nevybrali jste faktor</div>
			</div>
			 
			<div class="col-12 pt-3">
				<div class="custom-control custom-checkbox">
				  <input class="custom-control-input" type="checkbox" id="rozhodci<?php echo"$i";?>" name="RO">
				  <label class="custom-control-label" for="rozhodci<?php echo"$i";?>">
					Rozhodčí
				  </label>
				</div>
			</div>

			<div class="col-12 pt-3">
				<div class="custom-control custom-checkbox">
				  <input class="custom-control-input" type="checkbox" id="pomocnik<?php echo"$i";?>" name="POM">
				  <label class="custom-control-label" for="pomocnik<?php echo"$i";?>">
					Pomocník
				  </label>
				</div>
			</div>


			<div class="col-12 pt-3">
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
					<div class="toast-header">
					  <strong class="mr-auto text-primary font-weight-bolder">Pravidla registrace</strong>
					  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">×</button>
				  </div>
					<div class="toast-body ml-1">
						<p>Pořadatelé si vyhrazují právo dodatečně měnit zařazení závodníků do squadů dle potřeb hladkého průběhu závodu.</p>
						<p>V souladu s pravidlem 6.6.2 je účast v prematchi omezena na organizátory, sponzory a rozhodčí.</p>
						<p><strong>Rozhodčí se registrují po dohodě s RM.</p>
						<p>Registrace bez platby je platná maximálně 10 dnů.</strong> Po tomto termínu bude registrace zrušená. <br><i>- Neplatí pro organizátory, pomocníky a rozhodčí.</i></p>
						<p>Při zadání neplatné emailové adresy, se zbavujete možnosti být informováni o případných změnách.</p>
				
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
?>
<pre>
- rozhodčí <i class='far fa-clock' style='font-size:14px'></i>
- pomocník <i class='far fa-handshake' style='font-size:14px'></i>
- VIP <i class='far fa-crown' style='font-size:12px'></i>
<span class="<?php echo "$paymentBeforeClass"; ?> text-success">- zaplaceno nebo potvrzeno pořadatelem (pomocníci a rozhodčí)</span>
<span class="<?php echo "$paymentBeforeClass"; ?> font-weight-bold">- nezaplaceno</span>
<span class="<?php echo "$paymentBeforeClass"; ?> text-danger">- nezaplaceno s urgencí po 10 dnech</span>
</pre>

<script type="text/javascript" src="./js/pravidla.js"></script>
<script type="text/javascript" src="./js/form_validation.js"></script>
<script type="text/javascript" src="./js/validate_alias.js"></script>
<script type="text/javascript" src="./js/mdb.js"></script>

<?php include "./footer.php"; ?>