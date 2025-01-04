<?php
include "./db/dbconn.php";
include "./header.php";

// Performing SQL query

$result = mysql_query("
CREATE VIEW ec2021_uniq_alias AS
 SELECT Prijmeni,Jmeno,Alias
 FROM (SELECT Prijmeni,Jmeno,Alias
  FROM ec2021_1 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias
  FROM ec2021_2 where squad >=0
  union all
  SELECT Prijmeni,Jmeno,Alias
  FROM ec2021_3 where squad >=0)
temp
group by Alias
 having count(Alias)>0
ORDER BY Prijmeni,Jmeno
;");

$query = "
SELECT 
  ec2021_uniq_alias.Prijmeni,
  ec2021_uniq_alias.Jmeno,
  ec2021_uniq_alias.Alias
FROM ec2021_uniq_alias
  INNER JOIN (SELECT * FROM ec2021_uniq_alias
    group by Prijmeni,Jmeno
    having count(Prijmeni)>1 ) dup
   ON 
    ec2021_uniq_alias.Prijmeni = dup.Prijmeni";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>

<H2>Kontrola registračních údajů (1.-3. kolo)</H2>
<p>Tabulka obsahuje unikátní aliasy použité při registraci do jednotlivých kol série závodu tohoto roku.<br>
<i>- výjimkou jsou závodníci se stejným příjmením - <strong>pokud jsou pro konkrétní příjmení různá jména, je vše v pořádku :-)</strong></i></p>
<h6>Po kontrole pošlete změny <u><a style="color:#2a5a8e;" href="mailto:milan&#064;g17.cz?subject=Oprava registracnich udaju Eggeneberg CUP">statistikovi</a></u> nejpozději před posledním závodem série.</h6/>
<br>
<div class="row">
	<div class="col-md-8">
		<table id="zavodnici" class="table table-bordered border-primary bg-white table-striped">
		<tr>
			<th>Příjmení</th>
			<th>Jméno</th>
			<th>Alias</th>
		</tr>
		<tbody id="dataTable">
<?php
	while ($line = mysql_fetch_array($result)) {
	echo "<TR>
			<TD>".$line["Prijmeni"]."</TD>
			<TD>".$line["Jmeno"]."</TD>
			<TD>".$line["Alias"]."</TD>
		</TR>";
	}
?>
		</table>
	</div>
</div>

<?php include "./footer.php"; ?>