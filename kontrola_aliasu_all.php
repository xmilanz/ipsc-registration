<?php
   include "./header.php";
   
   
   if (file_exists('./db/dbconn.php')) {
       require_once './db/dbconn.php';
   } elseif (file_exists('../db/dbconn.php')) {
       require_once '../db/dbconn.php';
   }
   
   $result = mysql_query("
   CREATE VIEW ec_uniq_alias AS
   SELECT Prijmeni, Jmeno, Alias, Zavod
   FROM (
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2021_1 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2021_2 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2021_3 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2022_1 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2022_2 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2022_3 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2023_1 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2023_2 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2023_3 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2024_1 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2024_2 WHERE squad >= 0
       UNION ALL
       SELECT Prijmeni, Jmeno, Alias, Zavod FROM ec2024_3 WHERE squad >= 0
   ) temp
   GROUP BY Prijmeni, Jmeno, Alias
   HAVING COUNT(*) > 0
   ORDER BY Prijmeni, Jmeno, Alias;
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
     echo /*html*/ "<pre>:.. Nejsou žádní závodníci ke zpracování ..:</pre>";
   }
   
   ?>
<H2>Kontrola IPSC aliasů zadaných při registraci od roku 2021</H2>
<p>Tabulka obsahuje IPSC aliasy použité při registraci do <strong>jednotlivých kol</strong> Eggenberg CUPu od roku 2021.<br>
<h6>
<span class='text-danger'> Nejdůležitější je sice použít stejný IPSC alias v rámci jedné série, ale stejně je v zájmu každého závodníka používat stále stejný ;).</span> <br><br>Po kontrole prosím pošlete <u><a style="color:#2a5a8e;" href="mailto:<?php echo /*html*/ "$match_data[Zavod_email_stats]"; ?>?subject=Oprava registracnich udaju Eggenberg CUP">statistikovi</a></u> email s informací, <span class='text-danger'>který IPSC alias je správný (= zaregistrovaný)</span>.</h6/>
<br>
<div class="row">
   <div class="col-md-8">
      <table id="zavodnici" class="table table-bordered border-primary bg-white table-striped">
         <tr>
            <th>Příjmení</th>
            <th>Jméno</th>
            <th>IPSC alias</th>
            <th>Závod</th>
         </tr>
         <tbody id="dataTable">
            <?php
               while ($line = mysql_fetch_array($result)) {
               echo /*html*/ "<TR>
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