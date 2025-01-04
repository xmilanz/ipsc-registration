<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico" />
    <title>KPS Eggenberg - administrace registrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
</HEAD>
<BODY>

<?php
    require_once ("./auth.php");
    require_once ("./db/dbconn.php");

$sql="SELECT * FROM ".$table." WHERE Cislo=".$_GET[id];
$result = mysql_query($sql);

if (!$result) {
   echo 'MySQL Error: ' . mysql_error();
   exit;
}

if ($result) {
  $row = mysql_fetch_array($result);

echo "<h3 class='nadpis'>..: Závodník ".$row['Prijmeni']."  ".$row['Jmeno']." [".$_GET['id']."] :..</h3>";

echo "<FORM  class='edit_shooter' ACTION=\"./change.php\" METHOD=\"post\">";

echo "<span class=\"edit_shooter\">Alias </span>";
echo "<INPUT TYPE=TEXT NAME=alias VALUE=\"";
    echo $row['Alias'];
echo "\"><BR>\n";

echo "<span class=\"edit_shooter\">Příjmení </span>";
echo "<INPUT TYPE=TEXT NAME=prijmeni VALUE=\"";
    echo $row['Prijmeni'];
echo "\"><BR>\n";

echo "<span class=\"edit_shooter\">Jméno </span>";
echo "<INPUT TYPE=TEXT NAME=jmeno VALUE=\"";
    echo $row['Jmeno'];
echo "\"><BR>\n";

echo "<span class=\"edit_shooter\">E-mail </span>";
echo "<INPUT TYPE=TEXT NAME=email VALUE=\"";
    echo $row['Mail'];
echo "\"><BR>\n";

echo "<INPUT TYPE=HIDDEN NAME=Ulice VALUE=\"";
    echo $row['Ulice'];
echo "\">\n";

echo "<INPUT TYPE=HIDDEN NAME=Mesto VALUE=\"";
    echo $row['Mesto'];
echo "\">\n";

echo "<INPUT TYPE=HIDDEN NAME=Psc VALUE=\"";
    echo $row['Psc'];
echo "\">\n";

echo "<INPUT TYPE=HIDDEN NAME=varsym VALUE=\"";
    echo $row['VarSym'];
echo "\">\n";

echo "<span style=\"display:none;\"class=\"edit_shooter\">Region </span>";
echo "<INPUT TYPE=HIDDEN NAME=region VALUE=\"";
    echo $row['Region'];
echo "\"><BR>\n";

echo "<span class=\"edit_shooter\">Pistol Divize </span>";
    echo "<select name=pidiv>";
        echo "<option value=".$row[Pidiv].">".$row[Pidiv]."</option>";
        echo "<option value=\"PRD\">Production - PRD</option>";
        echo "<option value=\"STD\">Standard  - STD</option>";
        echo "<option value=\"OPN\">Open - OPN</option>";
        echo "<option value=\"REV\">Revolver - REV</option>";
        echo "<option value=\"CLA\">Classic - CLA</option>";
        echo "<option value=\"PCC\">PCC - PCC</option>"; 
        echo "<option value=\"PDO\">Production Optics - PDO</option>";
    echo "</select>";
echo "<BR>\n";

echo "<span class=\"edit_shooter\">Kategorie </span>";
    echo "<select name=kategorie>";
          echo "<option value=".$row[Kategorie].">".$row[Kategorie]."</option>";
          echo "<option value=REGULAR>Regular (běžná)</option>";
          echo "<option value=JUNIOR>Junior (do 21 let)</option>";
          echo "<option value=LADY>Lady (ženy)</option>";
          echo "<option value=SENIOR>Senior (nad 50 let)</option>";
          echo "<option value=SSENIOR>Super Senior (nad 60 let)</option>";
    echo "</select>";
echo "<BR>\n";

echo "<span class=\"edit_shooter\">Pistole Faktor </span>";
    echo "<select name=pifak>";
      echo "<option value=".$row[Pifak].">".$row[Pifak]."</option>";
      echo "<option value=MIN>Minor</option>";
      echo "<option value=MAJ>Major</option>";
    echo "</select>";
echo "<BR>\n";

echo "<span class=\"edit_shooter\">Squad </span>";
    echo "<select name=squad>";
    echo "<option value=".$row[Squad].">".$row[Squad]."</option>";
        echo "<option value=-2>Čekatelé</option>";
        echo "<option value=0>Prematch RO</option>";
        echo "<option value=1>1</option>";
        echo "<option value=2>2</option>";
        echo "<option value=3>3</option>";
        echo "<option value=4>4</option>";
        echo "<option value=5>5</option>";
        echo "<option value=6>6</option>";
        echo "<option value=7>7</option>";
        echo "<option value=8>8</option>";
        echo "<option value=-9>Vyřazení závodníka</option>";
    echo "</select>";
echo "<BR>\n";

echo "<span class=\"edit_shooter\">Rozhodčí</span> <INPUT TYPE=checkbox NAME=RO ";
 if ( $row['RO']=="on"){ echo "CHECKED";};
echo "><BR>\n";
echo "<span class=\"edit_shooter\">VIP</span> <INPUT TYPE=checkbox NAME=VIP ";
 if ( $row['VIP']=="on"){ echo "CHECKED";};
echo "><BR>\n";


echo "<BR>\n";

echo "<span class=\"edit_shooter\">Poznámka </span>";
echo "<INPUT TYPE=TEXT NAME=poznamka SIZE=20 VALUE=\"";
    echo $row['Poznamka'];
echo "\"><BR>\n";

echo "<INPUT TYPE=HIDDEN NAME=zaplaceno ";
 if ( $row['Zaplaceno']=="on"){ echo "CHECKED";};
echo ">\n";

echo "<INPUT TYPE=HIDDEN NAME=ZaplatiNaMiste ";
 if ( $row['ZaplatiNaMiste']=="on"){ echo "CHECKED";};
echo ">\n";

echo "<INPUT TYPE=HIDDEN NAME=serie ";
 if ( $row['serie']=="1"){ echo "CHECKED";};
echo ">\n";

echo "<INPUT TYPE=HIDDEN NAME=Castka SIZE=20 VALUE=\"";
 echo ($row['Castka']);
echo "\">\n";


echo "<INPUT TYPE=HIDDEN NAME=Mena SIZE=20 VALUE=\"";
 echo $row['Mena'];
echo "\">\n";

echo "<INPUT TYPE=HIDDEN NAME=DatumDodani SIZE=20 VALUE=\"";
 echo $row['DatumDodani'];
echo "\">\n";

echo "<INPUT TYPE=HIDDEN NAME=DatumZaplaceni SIZE=20 VALUE=\"";
 echo $row['DatumZaplaceni'];
echo "\">\n";

echo "<TEXTAREA style=\"display:none;\" NAME=InvoiceAddress rows=5 cols=50 maxlength=200>";
echo str_replace("<br />","",$row['InvoiceAddress']);
echo "</textarea>\n";

echo "<br>";
echo "<INPUT type=\"hidden\" name=cislo Value=\"";
echo $_GET["id"];
echo "\">\n";

echo "<center>";
    echo "<INPUT rel=\"modal:open\" style=\"background-color: green; width:auto; position: relative; left: 0px;color:white; font-size: 13px;  border: 0px; padding:5px; font-weight:bold; cursor:pointer; \" type=\"submit\" value=\"Uložit\" >";
    echo "&nbsp;&nbsp;<a href=\"index.php\" onclick=\"window.location.reload(true);\"><button style=\" padding:3px; cursor:pointer;\">Zavřít</button></a></center>";
echo "</center>";

echo "</FORM>";
echo "</BODY>\n</HTML>";
   exit;
}
?>