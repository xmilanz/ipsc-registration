<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once ("../config/data.php");
require_once ("db/dbconn.php");
require_once ("functions.php");
include ("include/exports.php");

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- bootstrap -->

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

	<script type="text/javascript" src="../js/form_validation.js"></script>

</HEAD>
<BODY>

<a class="text-decoration-none" href="<?php echo $web_adresa_admin; ?>" target="_blank">
    <div class="jumbotron p-2 m-0"><h2 class="text-center ">Administrace závodu <?php echo "$match_data[Zavod]"; 

    if ($match_data[Payment_before]=="on") {echo "<span class='text-danger small'> [<abbr title='Pokud závodník nezaplatí do 10 dnů od provedení registrace, je automaticky vyřazen'>platba startovného 10 dnů od registrace</abbr>]</span>";}
    else {echo "<span class='text-danger small'> [<abbr title='Závodník platí až v den závodu pokladníkovi na místě'>platba startovného na místě</abbr>]</span>";}
?>


</h2></div>
</a>

<nav class="navbar navbar-expand-sm">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
	<?php include ("./include/new.php");  ?>
    </li>
    <li class="nav-item">
      <a class="btn btn-primary btn-rounded" onclick="window.location.href='?export=1';" href='export/praktiscore_shooters.csv' download='praktiscore_shooters.csv'>Exportovat závodníky pro PS</a>
	<?php
	?>
    </li>
  </ul>

	<?php include ("include/match_config.php"); ?>

	<?php
	if ($match_data[Payment_before]=="on") {
		include ("./include/payment_before_off.php");  
	}
	else {
		include ("./include/payment_before_on.php");
	}
	?>
	<a class="btn btn-danger btn-rounded ml-5" href="logout.php" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover"><i class="fas fa-sign-out-alt"></i>&nbsp;Odhlásit [<?=$_SESSION['name']?>]</a>
</nav>
		<button class="btn btn-secondary btn-rounded my-3" onclick="ToggleFilter()">Zobrazit / skrýt filtr</button>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script>
function ToggleFilter() {
  var elements = document.getElementsByClassName("dtsb-searchBuilder");
  
  for (var i = 0; i < elements.length; i++) {
    var x = elements[i];
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
}
</script>

<?php
?>
<br>
<?php
$ip=$_SERVER["REMOTE_ADDR"];

if ($match_data[Payment_before]=="on"){
	$query=" SELECT 
		".$table.".Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,Region,DatReg,Pidiv AS Divize,Pifak AS 'PF',Kategorie,Squad,SquadReg,Staff,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS  Registrace,RegistraceIP AS 'IP&nbsp;registrace',Mail,VarSym AS 'VS',DatPay AS 'Zaplatit',ZaplatiNaMiste AS 'NaMiste',Zaplaceno,Castka,DatumZaplaceni AS 'Datum&nbsp;zaplaceni',Urgence,Vyrazeno,VyrazenoIP AS 'IP&nbsp;vyrazeni',Poznamka
	  FROM ".$table."
	  WHERE Squad >=-9 ";
	}
	else {
		$query=" SELECT 
		".$table.".Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,Region,DatReg,Pidiv AS Divize,Pifak AS 'PF',Kategorie,Squad,SquadReg,Staff,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS Registrace,RegistraceIP AS 'IP&nbsp;registrace',Mail,VarSym AS 'VS',Vyrazeno,VyrazenoIP AS 'IP&nbsp;vyřazení',Poznamka
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
// 4. závodník do 10 dnů nezaplatí (kontrola 10. den v 18:00) => automatické vyřazení

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

if ($z[serie]=="1") {
  $rowClass.=" kingscupserie";
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
        if ($row_array[serie]==1) {
          echo "onclick=\"return DotazSerie();\" ";
        }
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
echo "</table>\n";

echo "<div class='row $paymentBeforeClass mr-0'>";
 echo "<div class='col-12'>";
	echo "<b>Vyúčtování</b><br>";
	foreach ($sumaZaplaceno as $mena => $castka) {echo "- zaplaceno: $castka CZK"; }
 echo "</div>";
 echo "<div class='col-12 pt-3'>
		<b>Legenda</b><br>
		- registrováno<br>
		- rozhodčí, pomocníci a VIP neplatí (automaticky se potvrdí účast a neposílá se ani urgence ani se automaticky nevyřadí)<br>
		- <span style='background-color: #9fff9f'>zaplaceno</span><br>
		- <span style='color: #7433FF'>zaplatí na místě</span><br>
		- <span style='color: #ff0000; '>ruční urgence před limitem</span><br>
		- <span style='color: #ff0000; font-weight: bolder; '>zbývá méně jak 5 dní do zaplacení</span><br>
		- <span style='color:#858585;background-color: #d3d3d3'>vyřazeno</span><br><br>";
 echo "</div>";
echo "</div>";

include ("./include/pass_values.php");  
?>


</BODY>
</HTML>