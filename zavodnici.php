<?php
include "./header.php";
$stmt = $conn->prepare("
		SELECT Prijmeni,Jmeno,Alias,Divize,Faktor,Kategorie,Squad FROM $table 
        where Squad>=100 ORDER BY Prijmeni
	");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!-- dataTable https://datatables.net/download/ -->
<script type="text/javascript" src="js/datatable_conf.js"></script>
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/fc-5.0.4/fh-4.0.1/r-3.0.3/sp-2.3.3/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/fc-5.0.4/fh-4.0.1/r-3.0.3/sp-2.3.3/datatables.min.js"></script>
<!-- dataTable  -->

<h1 class='p-3'>Závodníci</h1>
<div class="col-md-12">
    <table id="zavodnici" class="table table-striped table-bordered bg-white">
        <thead>
            <tr>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>IPSC alias</th>
                <th>Divize</th>
                <th>Faktor</th>
                <th>Kategorie</th>
                <th>Squad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($line = mysqli_fetch_array($result)) {
                echo "<TR>";
                echo "<TD>";
                echo
                htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Divize'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Faktor'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Kategorie'], ENT_QUOTES, 'UTF-8') . "</TD><TD>" . htmlspecialchars($line['Squad'], ENT_QUOTES, 'UTF-8') . "</TD></TD>";
                echo "</TR>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include "./footer.php"; ?>