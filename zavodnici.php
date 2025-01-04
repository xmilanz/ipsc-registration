<?php
include "./db/dbconn.php";
include "./header.php";
$query = "SELECT Prijmeni,Jmeno,Pidiv,Pifak,Kategorie,Squad,VarSym,Potvrzeno,DatReg,RO,Zaplaceno,serie,FROM_UNIXTIME(DatReg) AS Registrace FROM ".$table." where Squad>=-5 ORDER BY Prijmeni";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>

<!-- dataTable https://datatables.net/download/ -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fh-3.2.2/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fh-3.2.2/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.js"></script>

<script type="text/javascript" src="js/datatable_conf.js"></script>

<!-- dataTable  -->
<body>
<H1 class='p-3'>Závodníci</H1>
<div class="col-md-12">
	<table id="zavodnici" class="table table-striped table-bordered bg-white">
        <thead>
            <tr>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>Divize</th>
                <th>Faktor</th>
                <th>Kategorie</th>
                <th>Squad</th>
            </tr>
        </thead>
		<tbody>
		<?php
		list($usec, $sec) = explode(" ", microtime());
		$dnes=date_format(new DateTime(),"Y-m-d H:i");
		$limit_platby=date('Y-m-d H:i', strtotime("-$zavod_pocet_dni_na_platbu", strtotime($dnes)));
		$citacRO=0;
		$citac=0;
		while ($line = mysql_fetch_array($result)) {
		  echo "\t<tr>\n";
			if (strpos($line["RO"],'on')===false) {
			$citac++;
		  } else {
			$citacRO++;
		  }
		  $serieIcon="";
		  $roIcon="";
		  $DatPay=date('Y-m-d', strtotime("+$zavod_pocet_dni_na_platbu day", $line["DatReg"]));
		  echo "<TD>";
		  if ($DatPay < $dnes AND $line[Zaplaceno]!=="on" and intval($line[Squad])>=0){echo "<font color=red>";};
		  if ($line[RO]=="on") {$roIcon="<img src='./images/ro_icon.png' valign='bottom'>";};
		  if ($line[Zaplaceno]=="on"){
			echo "<font color=green>"; 
			if ($line[serie]=="1") {
			  $serieIcon="<img src='./images/serieIcon.png' valign='bottom'/>";
			}
		  };
		  $squad=$nazvy_squadu[$line["Squad"]];
		  if ($squad=="0") {
			$squad="RO";
		  }
		  $squad=substr($squad, 0, 15);    
		echo $line["Prijmeni"]."</font>&nbsp;$roIcon&nbsp;$serieIcon</TD><TD>".$line["Jmeno"]."</TD><TD>".$line["Pidiv"]."</TD><TD>".$line["Pifak"]."</TD><TD>".$line["Kategorie"]."</TD><TD>".$squad."</TD></tr>\n";
		}
?>
	</table>
</div>

<?php
// pocty zavodniku, kteri zaplatili
$queryPLACENO="SELECT sum(case when Zaplaceno='on' then 1 else 0 end) as paid,count(Cislo) as shooters FROM $table WHERE Squad>0 AND (RO!='on' or VIP!='on')";
$resPLACENO=mysql_query($queryPLACENO);
$zPLACENO=mysql_fetch_array($resPLACENO);

// pocty zavodniku, kteri nezaplatili ani po urgenci
$queryPLATIT="SELECT sum(case when Zaplaceno IS NULL and Urgence!='' then 1 else 0 end) as unpaid,count(Cislo) as shooters FROM $table WHERE Squad>=0 AND (RO!='on' or VIP!='on')";
$resPLATIT=mysql_query($queryPLATIT);
$zPLATIT=mysql_fetch_array($resPLATIT);

$query = "SELECT Pidiv,Count(Prijmeni) as Count FROM ".$table." where Squad>=0 and Zaplaceno='on' and (RO!='on' or VIP!='on') GROUP BY Pidiv HAVING count(Prijmeni)>=0 ORDER BY Pidiv";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>	
<div class="row pl-3 pt-3">
	<div class="col-md-4">
		<table class="table table-bordered border-primary bg-white">
		<?php
		echo"<tr><th>Počet závodníků: $citac ($citacRO RO)</th></tr>";
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
			$queryCat="SELECT Kategorie,Count(Prijmeni) as Count FROM ".$table." where Squad>=0 and Pidiv='".$line[Pidiv]."' and Zaplaceno='on' and (RO!='on' or VIP!='on') GROUP BY Kategorie HAVING count(Prijmeni)>=0 ORDER BY Pidiv";
			$Cats=mysql_query($queryCat);
			while ($Cat=mysql_fetch_array($Cats)) {
			  echo "</dt><dd>&nbsp;&nbsp;<small>-&nbsp;".$Cat[Kategorie].": ".$Cat[Count]."</small></dd>";
			}
		}
		   echo "</dl></td></tr>";
		   echo"<tr><td>- zaplaceno: $zPLACENO[paid]<br>- nezaplaceno po urgenci: $zPLATIT[unpaid]</td></tr>";
?>
		</table>
	</div>


<?php 
$query = "SELECT Pidiv,Count(Prijmeni) FROM ".$table." where Squad>=0 GROUP BY Pidiv ORDER BY Pidiv";
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