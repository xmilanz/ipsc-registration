<?php

//error_reporting(64);
//ini_set('display_errors',1);
//error_reporting(E_WARNING);

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

if (file_exists('./db/dbconn.php')) {
    include './db/dbconn.php';
} elseif (file_exists('../db/dbconn.php')) {
    include '../db/dbconn.php';
}

// nastaveni poradatele pro soubor stylů
if ((strpos($match_data[Zavod_poradatel], 'Eggenberg')) !== false) {
	$poradatel="eggenberg";
}
elseif ((strpos($match_data[Zavod_poradatel], 'Pelhřimov')) !== false) {
	$poradatel="pelhrimov";
}
else {
	$poradatel="";
}


$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);
?>

<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico" />
    <title>Administrace závodu <?php echo "$match_data[Zavod]"; ?></title>

    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
	<link rel="stylesheet" href="../styles/style_<?php echo "$poradatel" . ".css"; ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- CSS pro datepicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<!-- JS pro datepicker a lokalizace pro češtinu -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.cs.min.js"></script>

<!-- dataTable https://datatables.net/download/ -->
    <script type="text/javascript" src="./js/datatable_conf.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.css"/>
<!-- dataTable https://datatables.net/download/ -->

	<script type="text/javascript" src="./js/admin_reg_form.js"></script>
	
</HEAD>
<BODY>
<div class="container">

<div class="header">
	<div class="header-logo">
		<img src="../images/logo-header-dvc.png" alt="Logo">
		<div class="text-over-image">
			<a class="logo-text" href="<?php echo $web_adresa_admin; ?>" target="_blank">
				<p>
					<?php echo "$match_data[Zavod] - administrace</a><br>"; 
					if ($match_data[Zavod_registrace_pozastaveno]=="on") {
						echo "<span class='text-danger tooltip '>[registrace je pozastavená]<span class='tooltiptext  lh-base'><strong>Spuštění registrace</strong> se provede v <span class='bg-success text-white' >Konfiguraci</span> - sekce <strong>Základní informace</strong></span></span>";
						}
					elseif ($match_data[Payment_before]=="on") {
						echo "<span class='text-danger tooltip '>[platba startovného $match_data[Zavod_pocet_dni_na_platbu] dnů od registrace]<span class='tooltiptext'>Startovné se platí před závodem, nejpozději do $match_data[Zavod_pocet_dni_na_platbu] dnů od provedení registrace.<br><br>Nezaplatí-li závodník do té doby, pošle se ráno upozornění na chybějící platbu.<br><br>Jestliže nezaplatí ani po tomto upozornění, je druhý den večer automaticky vyřazen.</span></span>";
						}
					else {
						echo "<span class='text-danger tooltip '>[platba startovného na místě]<span class='tooltiptext'>Závodník platí v den závodu při prezenci <strong>nejpozději 30 minut před závodem</strong></span></span>";
						}
					?>
				</p>
		</div>
	</div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
		<button href="" class="btn btn-success" data-toggle="modal" data-target="#match_configuration">Konfigurace</button>
      </li>

		<div class="dropdown" id="dropdownContainer1">
			<button class="btn btn-dark dropdown-toggle mx-2" id="dropdownButton1">Závodníci</button>
				<div class="custom-dropdown" id="customDropdown1">
					<a href="" data-toggle="modal" data-target="#new_shooter">Nový závodník</a>
					<a class="" onclick="startExport()" href="#">Export do PS</a>
				</div>
		</div>

		<div class="dropdown" id="dropdownContainer2">
			<button class="btn btn-dark dropdown-toggle mx-2" id="dropdownButton2">Nastavení soutěže</button>
				<div class="custom-dropdown" id="customDropdown2">
					<a href="" class="" data-toggle="modal" data-target="#manage_squads">Squady</a>
					<a href="" class="" data-toggle="modal" data-target="#manage_divisions">Divize</a>
					<a href="" class="" data-toggle="modal" data-target="#manage_categories">Kategorie</a>
				</div>
		</div>

    </ul>

	<?php
	if ($match_data[Payment_before]=="on") {
		include ("./include/payment_before_off.php");  
	}
	else {
		include ("./include/payment_before_on.php");
	}
	?>
       <a class="btn btn-danger text-white ml-4" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Odhlásit [<?=$_SESSION['name']?>]</a>
  </div>
</nav>

<div class="content">


<div class="filter">
<button class="btn btn-secondary btn-rounded my-3" onclick="ToggleFilter()">Zobrazit / skrýt filtr</button>
</div>

<?php
$ip=$_SERVER["REMOTE_ADDR"];

if ($match_data[Payment_before]=="on"){
	$query=" SELECT 
		".$table.".Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,ZP,Region,DatReg,Pidiv AS Divize,Pifak AS 'PF',Kategorie,Squad,SquadReg,Staff,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS  Registrace,RegistraceIP AS 'IP&nbsp;registrace',Mail,VarSym AS 'VS',DatPay AS 'Zaplatit',ZaplatiNaMiste AS 'NaMiste',Zaplaceno,Castka,DatumZaplaceni AS 'Datum&nbsp;zaplaceni',Urgence,Vyrazeno,VyrazenoIP AS 'IP&nbsp;vyrazeni',Poznamka
	  FROM ".$table."
	  WHERE Squad >=-9 ";
	}
	else {
		$query=" SELECT 
		".$table.".Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,ZP,Region,DatReg,Pidiv AS Divize,Pifak AS 'PF',Kategorie,Squad,SquadReg,Staff,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS Registrace,RegistraceIP AS 'IP&nbsp;registrace',Mail,VarSym AS 'VS',Vyrazeno,VyrazenoIP AS 'IP&nbsp;vyřazení',Poznamka
		FROM ".$table."";
	}
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>

 <table id="zavodnici" class="table table-striped table-bordered bg-white">
	<thead>
	<tr>
	<?php
 // Sestavujeme tabulku zavodniku
	for ($i=0; $i<(mysql_num_fields($result));$i++){
		$meta = mysql_fetch_field($result, $i);
		if ($meta->name=="DatReg") {
		  continue;
		}
		if (!$meta) {
			echo "--";
		}
		if ($meta->name=="VS") {
		  echo "<TH>Funkce</TH>";
		}
		echo "<TH>$meta->name</TH>";
	}
	?>
	</TR>
	</thead>

 <?php
  while ($row_array = mysql_fetch_array($result)){
  $z=$row_array;
  $rowClass="";
  
  $dnes=date_format(new DateTime(),"Y-m-d");
  $DatReg=date('d.m.Y', $z[DatReg]);
  
  // harmonogram registrace
  // 1. zavodnik se zaregistruje
  // 2. při registraci se automaticky posle mail s platebními údaji (QR kód) a s odkazem na případné zrušení registrace
  //	- z kontroly placení jsou vyřazeni: rozhodčí, pomocníci, VIP, čekatelé a platící předem
  // 3. zavodnik do 10 dnu zaplatí nebo sám zruší registraci pomocí odkazu v registračním mailu
  // 4. závodník do 10 dnů nezaplatí (kontrola 10. den v 06:00) - automaticky se pošle email s urgencí platby 
  // 5. závodník ani po urgenci nezaplatí (kontrola 11. den v 18:00) => automatické vyřazení
  
  // podminene formatovani
  if ($z[NaMiste]=='on') {
    $rowClass.=" zaplatinamiste";
  }

  if ($z[Zaplaceno]=='on') {
    $rowClass.=" zaplaceno";
    $mena=$z[Mena];
    $castka=$z[Castka];
    $sumaZaplaceno[$mena]=$sumaZaplaceno[$mena]+$castka;
  }
  
  if ($z[Squad]=="-9") {
    $rowClass.=" zrusenaregistrace";
  }
  
  if ($z[Urgence]!="") {
    $rowClass.=" urgence";
  }
  
  if ((($dnes >= date('Y-m-d', strtotime($z[Zaplatit]. ' - 5 days'))) and ($row_array[Squad]>=100) and ($row_array[Staff]==NULL) and ($row_array[Zaplaceno]!=="on"))) {
    $rowClass.=" nezaplacenopolimitu";
  }
  
  if ($match_data[Payment_before]=="") {
     $paymentBeforeClass.=" d-none";
  }
  // konec podminene formatovani
  
  echo "<TR class='$rowClass'>";
  	for ($i=0; $i<(mysql_num_fields($result));$i++){
      $meta = mysql_fetch_field($result, $i); 
      $pole=$meta->name;
      if ($meta->name=="DatReg") {
        continue;
      }
  		if ($i==0) {
  			echo "<TD class='$pole'>".$row_array[$i]."</a>";
        echo "</TD>\n";
  		} elseif ($pole=="Zaplaceno")
  
  		{
  		if(!$row_array['Zaplaceno']){
  			echo "<TD class='$pole'>";
  			echo "</TD>";
  		}  else {
          echo "<TD class='$pole'>";
  			echo "<center><i class='fas fa-coins' style='font-size:18px; color:#FF9900;'></i></a></center>";
          echo "</TD>";
  			};
  		} 
  		else{
  		    if ($pole=='VS') {
          echo "<td class='functions'>";
          if (intval($row_array[Squad])>-10) { 
  			echo "<a data-id='$row_array[Cislo]' href='#edit_shooter' class='modal_edit_shooter' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Upravit závodníka'><i class='fas fa-edit' style='font-size:15px'></i></a>";
  			echo "&nbsp;<a data-id='$row_array[Cislo]' href='#send_regmail' class='modal_regmail' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Poslat závodníkovi registrační email'><i class='fas fa-envelope 1' style='font-size:15px'></i></a>";
  			if ($row_array[Zaplaceno]!=="on" and $row_array[NaMiste]!=="on") {
  				echo "&nbsp;<a data-id='$row_array[Cislo]' href='#send_paymail' class='modal_paymail $paymentBeforeClass' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Poslat závodníkovi upozornění na nezaplacení'><i class='fas fa-exclamation-triangle 1' style='font-size:15px;color:gold;'></i></a>";
  				echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#save_payment' class='modal_save_payment $paymentBeforeClass' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Označit jako ZAPLACENO'><i class='fas fa-check-circle 1' style='font-size:15px;color:#40a73f;'></i></a>";
  			}
  			echo "&nbsp;<a data-id='$row_array[Cislo]' data-key='$row_array[Klic]' href='#cancel_shooter' class='modal_cancel_shooter' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Vyřadit závodníka'><i class='fas fa-minus-circle 1' style='font-size:15px;color:#6d757d;'></i></a>";
  			echo "&nbsp;<a data-id='$row_array[Cislo]' href='#info_shooter' class='modal_info_shooter' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Informace o závodníkovi'><i class='fas fa-info-circle 1 text-warning' style='font-size:16px;'></i></a>";
  			if ($_SESSION[name]=="milan.zidek") {
  				echo "&nbsp;<a data-id='$row_array[Cislo]' href='#delete_shooter' class='modal_delete_shooter' data-toggle='modal' data-backdrop='static' data-keyboard='false' title='Smazat závodníka'><i class='fas fa-trash-alt' style='font-size:15px;color:#ff0000;' 1></i></a>";
  			}
          }
          echo "</td>";
        }      
        echo "<TD class='$pole'>".$row_array[$i]."</TD>";	
  		};
  	};
  echo "</TR>";
  };
 ?>
 </table>

 <div>
	<h5>Vyúčtování</h5>
	<?php foreach ($sumaZaplaceno as $mena => $castka) {echo "- zaplaceno: $castka CZK<br><br>"; } ?>

		<h5>Legenda</h5>
		- registrováno<br>
		- rozhodčí, pomocníci a VIP neplatí (automaticky se potvrdí účast a neposílá se ani urgence ani se automaticky nevyřadí)<br>
		- <span style='background-color: #9fff9f'>zaplaceno</span><br>
		- <span style='color: #7433FF'>zaplatí na místě</span><br>
		- <span style='color: #ff0000; '>ruční urgence před limitem</span><br>
		- <span style='color: #ff0000; font-weight: bolder; '>zbývá méně jak 5 dní do zaplacení</span><br>
		- <span style='color:#858585;background-color: #d3d3d3'>vyřazeno</span> (ve výchozím nastavení se nezobrazuje -> filtr) <br><br>
 </div>
  
</div>
<div class="footer">Klub praktické střelby Eggenberg &copy; Milan Žídek <?php echo date("Y"); ?></div>
</div>

<script type="text/javascript" src="./js/admin_scripts.js"></script>

<?php 
	include_once ("./include/match_config.php");
	include_once ("./include/new.php");
	include_once ("./include/categories.php");
	include_once ("./include/divisions.php");
	include_once ("./include/squads.php");
	include_once ("./include/pass_values.php");  
?>

</BODY>
</HTML>