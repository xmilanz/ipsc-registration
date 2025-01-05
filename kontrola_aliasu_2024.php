<?php
include "./db/dbconn.php";
include "./header.php";

$current_year = date_format(new DateTime(),"Y");

// Performing SQL query

$result = mysql_query("
CREATE VIEW ec_uniq_alias_$current_year AS
SELECT Prijmeni,Jmeno,Alias,Zavod
 FROM (
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec$current_year_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec$current_year_2 where squad >=0
  union all
   SELECT Prijmeni,Jmeno,Alias,Zavod
  FROM ec$current_year_3 where squad >=0
  )
temp
group by Prijmeni,Jmeno,Alias
 having count(*)>0
ORDER BY Prijmeni,Jmeno,Alias
;");

$query = "
SELECT ec_uniq_alias_$current_year.Prijmeni,ec_uniq_alias_$current_year.Jmeno,ec_uniq_alias_$current_year.Alias,ec_uniq_alias_$current_year.Zavod FROM ec_uniq_alias_$current_year
  INNER JOIN 
	(SELECT * FROM ec_uniq_alias_$current_year
		group by Prijmeni,Jmeno
		having count(Prijmeni)>1 
	) AS dupl 
	ON 
		ec_uniq_alias_$current_year.Prijmeni = dupl.Prijmeni AND ec_uniq_alias_$current_year.Jmeno = dupl.Jmeno
	";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

if (!$result) {
  echo "<pre>:.. Nejsou žádní závodníci ke zpracování ..:</pre>";
}

?>

<H2>Kontrola aliasů Eggenberg CUPU <?php echo "$current_year"; ?></H2>
<p>Tabulka obsahuje aliasy použité při registraci do <strong>jednotlivých kol</strong> EggenbergCUP od <?php echo "$current_year"; ?><br>
<h6><span class='text-danger'>Pro vyhodnocení turnaje je nutné, aby závodník používal stejný alias.</span> Po kontrole prosím pošlete <u><a style="color:#2a5a8e;" href="mailto:milan&#064;g17.cz?subject=Oprava registracnich udaju Eggeneberg CUP <?php echo "$current_year"; ?>">statistikovi email</a></u> s informací, <span class='text-danger'>který alias je správný (= zaregistrovaný na ipsc-tech.org)</span>.</h6/>
<br>
<div class="row">
	<div class="col-md-8">
		<table id="zavodnici" class="table table-bordered border-primary bg-white table-striped">
		<tr>
			<th>Příjmení</th>
			<th>Jméno</th>
			<th>Alias</th>
			<th>Závod</th>
		</tr>
		<tbody id="dataTable">
<?php
	while ($line = mysql_fetch_array($result)) {
	echo "<TR>
			<TD>".$line["Prijmeni"]."</TD>
			<TD>".$line["Jmeno"]."</TD>
			<TD>".$line["Alias"]."</TD>
			<TD>".$line["Zavod"]."</TD>
		</TR>";
	}
?>
		</table>
	</div>
</div>

<?php include "./footer.php"; ?>