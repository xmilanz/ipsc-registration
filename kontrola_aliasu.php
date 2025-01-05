<?php
include "./db/dbconn.php";
include "./header.php";

$result = mysql_query("
CREATE VIEW ec_uniq_alias AS
SELECT Prijmeni,Jmeno,Alias,Zavod
 FROM (
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2021_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2021_2 where squad >=0
  union all
   SELECT Prijmeni,Jmeno,Alias,Zavod
  FROM ec2021_3 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2022_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2022_2 where squad >=0
  union all
   SELECT Prijmeni,Jmeno,Alias,Zavod
  FROM ec2022_3 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2023_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2024_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias,Zavod
   FROM ec2024_2 where squad >=0
  union all
   SELECT Prijmeni,Jmeno,Alias,Zavod
  FROM ec2024_3 where squad >=0
  )
temp
group by Prijmeni,Jmeno,Alias
 having count(*)>0
ORDER BY Prijmeni,Jmeno,Alias
;");

$query = "
SELECT ec_uniq_alias.Prijmeni,ec_uniq_alias.Jmeno,ec_uniq_alias.Alias,ec_uniq_alias.Zavod FROM ec_uniq_alias
  INNER JOIN 
	(SELECT * FROM ec_uniq_alias
		group by Prijmeni,Jmeno
		having count(Prijmeni)>1 
	) AS dupl 
	ON 
		ec_uniq_alias.Prijmeni = dupl.Prijmeni AND ec_uniq_alias.Jmeno = dupl.Jmeno
	";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

if (!$result) {
  echo "<pre>:.. Nejsou žádní závodníci ke zpracování ..:</pre>";
}

?>

<H2>Kontrola alisů zadaných při registraci od roku 2021</H2>
<p>Tabulka obsahuje aliasy použité při registraci do <strong>jednotlivých kol</strong> Eggenberg CUPu od roku 2021.<br>
<h6><span class='text-danger'> Nejdůležitější je sice použít stejný alias v rámci jedné série, ale stejně je v zájmu každého závodníka používat stále stejný alias ;).</span> <br><br>Po kontrole prosím pošlete <u><a style="color:#2a5a8e;" href="mailto:milan&#064;g17.cz?subject=Oprava registracnich udaju Eggenberg CUP">statistikovi email</a></u> s informací, <span class='text-danger'>který alias je správný (= zaregistrovaný)</span>.</h6/>
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