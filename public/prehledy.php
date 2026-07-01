<?php
include "./header.php";
$stmt = $conn->prepare("
		SELECT Prijmeni,Jmeno,Alias,Divize,Faktor,Kategorie,Squad FROM $table 
        where Squad>=100 ORDER BY Prijmeni
	");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// celkovy pocet závodníků (zaplaceno, VIP, rozhodčí a pomocníci)
echo "<h3 class='pl-3 pt-3'>Obsazenost divizí a kategorií</h3>";
if ($match_data['Payment_before'] == 0) {
    $stmt = $conn->prepare("
		SELECT count(Alias) as comp FROM $table
		where Squad >= 100
	");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $stmt = $conn->prepare("
        SELECT count(Alias) as comp FROM $table    
        where Squad >= 100 and Zaplaceno = 1   
        ");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
}
$zavodniciCelkem = $result->fetch_object()->comp;

// pocet neplaticich zavodniku (VIP, rozhodci a pomocnici)
$stmt = $conn->prepare("
    SELECT count(Alias) as notpay FROM $table    
    where Squad >= 100 and (Staff  = 'RO' or Staff = 'POM' or Staff = 'VIP')
");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$zavodniciNeplati = $result->fetch_object()->notpay;

// pocet zavodniku, kteri zaplatili
$stmt = $conn->prepare("
    SELECT count(Alias) as paid FROM $table    
    where Squad >= 100 and Zaplaceno = 1
");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$zavodniciZaplaceno = $result->fetch_object()->paid;

// pocet zavodniku, kteri dosud nezaplatili 
$stmt = $conn->prepare("
    SELECT count(Alias) as unpaid FROM $table    
    where Squad >= 100 and Zaplaceno IS NULL
");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$zavodniciNezaplaceno = $result->fetch_object()->unpaid;

// tabulky

$paidOnly = $match_data['Payment_before'] == 1;

$sqlDiv = "
    SELECT Divize, COUNT(Alias) AS Count
    FROM $table
    WHERE Squad >= 100
";

if ($paidOnly) {
    $sqlDiv .= " AND Zaplaceno = 1";
}

$sqlDiv .= " GROUP BY Divize ORDER BY Divize";

$stmt = $conn->prepare($sqlDiv);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="row pl-3 pt-3">
    <div class="col-md-4">
        <table id="zavodnici" class="table table-bordered bg-white">
            <?php
            echo "<thead><tr><th colspan='2'>Počet závodníků: <small>$zavodniciCelkem ($zavodniciNeplati rozhodčích a pomocníků)</small></th></tr></thead>";
            echo "<tbody>";

            while ($line = $result->fetch_assoc()) {
                $divize = $line['Divize'];
                $nazevDivize = getValueFromTable($conn, $table_divisions, "Name", $divize, "Value");
                echo "<tr><td><dt>$nazevDivize</dt>";

                // ---------- kategorie ----------
                $sqlCat = "
                    SELECT Kategorie, COUNT(Prijmeni) AS Count
                    FROM $table
                    WHERE Squad >= 100 AND Divize = ?
                ";

                if ($paidOnly) {
                    $sqlCat .= " AND Zaplaceno = 1";
                }

                $sqlCat .= " GROUP BY Kategorie ORDER BY Kategorie";

                $stmt = $conn->prepare($sqlCat);
                $stmt->bind_param("s", $divize);
                $stmt->execute();
                $cats = $stmt->get_result();
                $stmt->close();

                while ($cat = $cats->fetch_assoc()) {
                    echo "<dd>&nbsp;&nbsp;<small>- {$cat['Kategorie']}: {$cat['Count']}</small></dd>";
                }

                echo "</td></tr>";
            }

            echo "</td></tr></tbody>";

            ?>
        </table>
    </div>
    <?php

    // tabulka s pocty zavodniku v jednotlivych divizich

    if ($match_data['Payment_before'] == 1) {
        $stmt = $conn->prepare("
        SELECT Divize,count(Alias) as Count FROM $table
        where Squad >= 100 and Zaplaceno=1 GROUP BY Divize HAVING count(Alias)>=1 ORDER BY Divize
        
    ");
    } else {
        $stmt = $conn->prepare("
        SELECT Divize,count(Alias) as Count FROM $table
        where Squad >= 100 GROUP BY Divize HAVING count(Alias)>=1 ORDER BY Divize
    ");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    ?>
    <div class="col-md-4">
        <table id="zavodnici" class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Divize</th>
                    <th>Počet závodníků</th>

                </tr>
            </thead>
            <?php
            while ($line = $result->fetch_assoc()) {
                $nazevDivize = getValueFromTable($conn, $table_divisions, "Name", $line['Divize'], "Value");
                echo "<tbody><tr><td>" . $nazevDivize . "</td><td>" . htmlspecialchars($line['Count'], ENT_QUOTES, 'UTF-8') . "</td></tr><tbody>";
            }
            ?>

        </table>
    </div>
    <?php
    // tabulka s pocty zavodniku v jednotlivych kategoriích
    if ($match_data['Payment_before'] == 1) {
        $stmt = $conn->prepare("
        SELECT Kategorie,count(Alias) as Count FROM $table    
        where Squad >= 100 and Zaplaceno=1 GROUP BY Kategorie HAVING count(Alias)>=1 ORDER BY Kategorie
    ");
    } else {
        $stmt = $conn->prepare("
        SELECT Kategorie,count(Alias) as Count FROM $table    
        where Squad >= 100 GROUP BY Kategorie HAVING count(Alias)>=1 ORDER BY Kategorie
    ");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    ?>
    <div class="col-md-4">
        <table id="zavodnici" class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Kategorie</th>
                    <th>Počet závodníků</th>
                </tr>
            </thead>
            <?php
            while ($line = $result->fetch_assoc()) {
                $nazev_kategorie = getValueFromTable($conn, $table_categories, "Name", $line['Kategorie'], "Value");
                echo "<tbody><tr><td>" . $nazev_kategorie . "</td><td>" . htmlspecialchars($line['Count'], ENT_QUOTES, 'UTF-8') . "</td></tr><tbody>";
            }
            ?>
        </table>
    </div>
</div>
<div class="row <?= hidden($match_data['Payment_before'] == 0); ?>">
    <div class="my-3">
        <h3>Přehled placení</h3>
        <ul>
            <li>zaplaceno: <?= $zavodniciZaplaceno ?></li>
            <li>nezaplaceno: <?= $zavodniciNezaplaceno ?></li>
        </ul>
    </div>
</div>
<?php
include "./footer.php";
?>