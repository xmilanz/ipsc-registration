<?php
include "./header.php";

$query = "SELECT Prijmeni,Jmeno,Alias,Pidiv,Pifak,Kategorie,Squad FROM ".$table." where Squad>=100 ORDER BY Prijmeni";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>

<!-- dataTable https://datatables.net/download/ -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fh-3.2.2/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.css"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fh-3.2.2/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.js"></script>
	<script type="text/javascript" src="js/datatable_conf.js"></script>
<!-- dataTable  -->

<H1 class='p-3'>Závodníci</H1>
<div class="col-md-12">
  <table id="zavodnici" class="table table-striped table-bordered bg-white">
    <thead>
       <tr>
          <th>Příjmení</th>
          <th>Jméno</th>
          <th>Alias</th>
          <th>Divize</th>
          <th>Faktor</th>
          <th>Kategorie</th>
          <th>Squad</th>
       </tr>
    </thead>
  	<?php
  	while ($line = mysql_fetch_array($result)) {
  	  echo "\t<tr>\n";
  	  echo "<TD>";
		echo $line["Prijmeni"]."</TD><TD>".$line["Jmeno"]."</TD><TD>".$line["Alias"]."</TD><TD>".$line["Pidiv"]."</TD><TD>".$line["Pifak"]."</TD><TD>".$line["Kategorie"]."</TD><TD>".$line["Squad"]."</TD></tr>\n";
  	}
  	?>
  </table>
</div>

<?php
// --------------------------- //
// tabulka s pocty zavodniku  //
// -------------------------- //

// celkovy pocet závodníků (zaplaceno, VIP, rozhodčí a pomocníci)
if ($match_data[Payment_before]!=="on") {
   $queryCOMP="SELECT count(Alias) as comp FROM $table WHERE Squad>=100";
	}
else {
	echo"<H3 class='pl-3 pt-3'>Závodníci s potvrzenou účastí</H3>
		 <small class='pl-3'>- zaplaceno, rozhodčí a pomocníci</small>";
	$queryCOMP="SELECT count(Alias) as comp FROM $table WHERE Squad>=100 and Zaplaceno='on'";
}
$resCOMP=mysql_query($queryCOMP);
$zCOMP=mysql_fetch_array($resCOMP);

// pocet neplatících závodníků (VIP, rozhodčí a pomocníci)
$queryNEPLATI="SELECT count(Alias) as neplatici FROM $table where Squad >= 100 and (Staff='RO' or Staff='POM' or Staff='VIP')";
$resNEPLATI=mysql_query($queryNEPLATI);
$zNEPLATI=mysql_fetch_array($resNEPLATI);

// pocet zavodniku, kteri zaplatili
$queryPLACENO="SELECT count(Alias) as paid FROM $table WHERE Zaplaceno='on' and Squad>=100";
$resPLACENO=mysql_query($queryPLACENO);
$zPLACENO=mysql_fetch_array($resPLACENO);

// pocet zavodniku, kteri dosud nezaplatili
$queryNEPLACENO="SELECT count(Alias) as unpaid FROM $table WHERE Zaplaceno IS NULL and Squad>=100";
$resNEPLACENO=mysql_query($queryNEPLACENO);
$zNEPLACENO=mysql_fetch_array($resNEPLACENO);

if ($match_data[Payment_before]=="") {
	$query = "SELECT Pidiv,Count(Alias) as Count FROM $table where Squad>=100 GROUP BY Pidiv HAVING count(Alias)>=0 ORDER BY Pidiv";
	}
else {
	$query = "SELECT Pidiv,Count(Alias) as Count FROM $table where Squad>=100 and Zaplaceno='on' GROUP BY Pidiv HAVING count(Alias)>=0 ORDER BY Pidiv";
}

$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>	
<div class="row pl-3 pt-3">
	<div class="col-md-4">
		<table class="table table-bordered border-primary bg-white">
		<?php
		echo"<tr><th>Počet závodníků: $zCOMP[comp] ($zNEPLATI[neplatici] rozhodčích a pomocníků)</th></tr>";
		echo "<tr><td><dl>";
		while ($line = mysql_fetch_assoc($result)) {
			  if ($line[Pidiv]=="OPN") {
				$Divize=str_replace("OPN","Open","$line[Pidiv]");
				echo "<dt>$Divize</dt>";
			  }
			  if ($line[Pidiv]=="PRD") {
				$Divize=str_replace("PRD","Production","$line[Pidiv]");
				echo "<dt>$Divize</dt>";
			  }		  
			  if ($line[Pidiv]=="STD") {
				$Divize=str_replace("STD","Standard","$line[Pidiv]");
				echo "<dt>$Divize</dt>";
			  }		  
			  if ($line[Pidiv]=="CLA") {
				$Divize=str_replace("CLA","Classic","$line[Pidiv]");
				echo "<dt>$Divize<d/t>";
			  }		  
			  if ($line[Pidiv]=="REV") {
				$Divize=str_replace("REV","Revolver","$line[Pidiv]");
				echo "<dt>$Divize</dt>";
			  }		  
			  if ($line[Pidiv]=="PDO") {
				$Divize=str_replace("PDO","Production Optics","$line[Pidiv]");
				echo "<dt>$Divize</dt>";
			  }
			  if ($line[Pidiv]=="PCC") {
				//$Divize=str_replace("PCC","PCC","$line[Pidiv]");
				$Divize="PCC";
				echo "<dt>$Divize</dt>";
			  }

			if ($match_data[Payment_before]=="") {
				$queryCat="SELECT Kategorie,Count(Prijmeni) as Count FROM ".$table." where Squad>=100 and Pidiv='".$line[Pidiv]."' GROUP BY Kategorie HAVING count(Prijmeni)>=0 ORDER BY Pidiv";
				}
			else {
				$queryCat="SELECT Kategorie,Count(Prijmeni) as Count FROM ".$table." where Squad>=100 and Pidiv='".$line[Pidiv]."' and Zaplaceno='on' GROUP BY Kategorie HAVING count(Prijmeni)>=0 ORDER BY Pidiv";
				}
			$Cats=mysql_query($queryCat);
			while ($Cat=mysql_fetch_array($Cats)) {
			  echo "</dt><dd>&nbsp;&nbsp;<small>-&nbsp;".$Cat[Kategorie].": ".$Cat[Count]."</small></dd>";
			}
		}
		   echo "</dl></td></tr>";
		   echo"<tr class='$paymentBeforeClass'><td>
			- zaplaceno: $zPLACENO[paid]<br>
			- nezaplaceno: $zNEPLACENO[unpaid]<br>
			</td></tr>";
?>
		</table>
	</div>

<?php 

if ($match_data[Payment_before]=="") {
	$query = "SELECT Pidiv,Count(Prijmeni) FROM ".$table." where Squad>=100 GROUP BY Pidiv ORDER BY Pidiv";
	}
else {
	$query = "SELECT Pidiv,Count(Prijmeni) FROM ".$table." where Squad>=100 and Zaplaceno='on' GROUP BY Pidiv ORDER BY Pidiv";
}
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());

/* DIVIZE */
?>
	<div class='col-md-3'>
		<table class='table table-bordered border-primary bg-white table-striped'>
			<tr><th>Divize</th><th>Počet</th></tr>
			<?php 
			while ($line = mysql_fetch_assoc($result)) {
			   echo "<tr>";
			   foreach ($line as $col_value) {
				   echo "<td>$col_value</td>"; 
			   }
			   echo "</tr>";
			}
			?>
		</table>
	</div>
</div>

<?php include "./footer.php"; ?>
