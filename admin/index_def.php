<?php
ini_set('display_errors',1);
error_reporting(E_WARNING);
    require_once ("./../config/data.php");
	require_once ("auth.php");
	require_once ("./db/dbconn.php");
	require_once ("./functions.php");
	include ("./exports.php");

?>

<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/pics/favicon.ico" />
    <title>KPS Eggenberg - administrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<script type="text/javascript" src="../js/search.js"></script>
</HEAD>
<BODY>
<h3 class="nadpis">..: <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>" target="_blank"><?php echo "$zavod"; ?></a> - administrace :..</a></h3>
<h4>Seznam závodníků pro WinMSS a scoresheets</h4>
<button style="cursor:pointer;" onclick="window.location.href='?xml=1';">Generovat</button>

<?php
if ($xml) {
echo "
<a href='xml/competitors_scoresheets.csv' download='competitors_scoresheets.csv'>
<button style='cursor:pointer; '>Uložit závodníky pro scoresheety</button></a>
<a href='xml/WinMSS.ZIP' download='WinMSS.ZIP'>
<button style='cursor:pointer;'>Uložit ZIP pro WinMSS</button></a>
&nbsp&nbsp&nbsp<i>(Exportují se pouze závodníci, kteří zaplatili)</i>
";
}
?>

<?php
$ip=$_SERVER["REMOTE_ADDR"];

echo "<BR><BR>";
$seradit=$_GET[seradit];

if ($_GET[seradit]==""){
  $seradit="Cislo";
};

if ($seradit=="Zaplaceno") {
  $seradit="(case when Zaplaceno='On' then 999 else 0 end) DESC, STR_TO_DATE(DatumZaplaceni, '%d.%m.%Y') ASC";

}

if ($seradit=="Squad") {
  $seradit.=",Squad DESC";
}

$query="
  SELECT 
    ".$table.".Cislo,Prijmeni AS 'Příjmení',Jmeno AS 'Jméno',Alias,Mail,DatReg,Pidiv AS Divize,Pifak AS 'PF',Kategorie,Squad,RO,VIP,Klic,FROM_UNIXTIME(DatReg,'%d.%m.%Y %T') AS Registrace,RegistraceIP,VarSym,Urgence,Vyrazeno,VyrazenoIP,Zaplaceno,Castka,DatumZaplaceni,Poznamka
    ,(select case when (count(Prijmeni)-1)>0 AND ".$table.".Squad>-9 then 'DUPL' else '' end FROM ".$table." data2 WHERE data2.Prijmeni=".$table.".Prijmeni and data2.Jmeno=".$table.".Jmeno) as Duplicita
  FROM ".$table." ORDER BY ".$seradit."";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

//echo "<code>$query</code>";
?>
<h4>Závodníci</h4>
<a HREF='./new.php' rel="modal:open" title='Nový závodník'><button style="cursor:pointer;">Nový</button></a>
<br>
<br>
<br>


<input id="myInput" type="text" placeholder="Hledat závodníka">
<br>
<br>
<span style="font-size:small;">Seřadit podle:&nbsp;
<a href=./index.php?&seradit=Cislo>Číslo</a>&nbsp;|&nbsp;
<a href=./index.php?seradit=Prijmeni>Příjmení</a>&nbsp;|&nbsp;
<a href=./index.php?seradit=Squad>Squad</a>&nbsp;|&nbsp;
<a href=./index.php?seradit=RO%20DESC>Rozhodčí</a>&nbsp;|&nbsp;
<a href=./index.php?&seradit=Pidiv,Kategorie>Divize+Kategorie</a>&nbsp;|&nbsp;
<a href=./index.php?&seradit=Zaplaceno>Zaplaceno</a>&nbsp;|&nbsp;
<a href=./index.php?&seradit=duplicita%20DESC,Prijmeni>Duplicita</a>
</span>

<?php
echo "<TABLE id='registrationlist'>
<TR>";

// Sestavuvujeme tabulku zavodniku
for ($i=0; $i<(mysql_num_fields($result));$i++){
    $meta = mysql_fetch_field($result, $i);
    if ($meta->name=="DatReg") {
      continue;
    }
    if (!$meta) {
        echo "--";
    }
    if ($meta->name=="VarSym") {
      echo "<TH>Funkce</TH>";
      echo "<TH>Termín platby</TH>";
    }
    echo "<TH>$meta->name</TH>";
}
echo "</TR>";

while ($row_array = mysql_fetch_array($result)){
$z=$row_array;
$rowClass="";

$DatReg=date('d.m.Y', $z["DatReg"]);
$DatPay=date('Y-m-d', strtotime("+$zavod_pocet_dni_na_platbu day", $z["DatReg"]));
$dnes=date_format(new DateTime(),"Y-m-d");

// harmonogram registrace
// 1. zavodnik se zaregistruje
// 2. při registraci se automaticky posle mail s platebními údaji (QR kód) a s odkazem na případné zrušení registrace
//	- závodníci ve squadu >=0 (prematch a čekatelé) ani rozhodčím jsou vyřazeni z kontroly placení
// 3. zavodnik do 10 dnu zaplatí sám zruší registraci pomocí odkazu v registračním mailu
// 4. závodník do 10 dnů nezaplatí (kontrola 10. den v 6:00) => urgence platby
// 5. čekáme na zaplacení ještě 2 dny po urgenci (kontrola 3. den 1:00) => automatické vyřazení


// podminene formatovani
if ($z[Duplicita]!='') {
  $rowClass.=" duplicita";
}

if ($z[Potvrzeno]=="on") {
  $rowClass.=" potvrzeno";
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

//if (($DatPay<=$dnes)and($row_array[Squad]<0))and($row_array[Zaplaceno]!=="on")) {
  if ((($DatPay<=$dnes)and($row_array[RO]!=="on")and($row_array[Zaplaceno]!=="on")) AND (($DatPay<=$dnes)and($row_array[Squad]>=0)and($row_array[Zaplaceno]!=="on")) AND (($DatPay<=$dnes)and($row_array[Squad]>=0)and($row_array[VIP]!=="on"))) {
  $rowClass.=" nezaplacenopolimitu";
}

if ($z[serie]=="1") {
  $rowClass.=" kingscupserie";
}
// podminene formatovani

echo "\n<tbody id='searchArea'><TR class='$rowClass'>";

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
          echo "<center><img src=../images/paid.png ALT=Zaplaceno></a></center>";
        echo "</TD>";
			};
		} 
		else{
		    if ($pole=='VarSym') {
        echo "<td class='functions'>";
        if (intval($row_array[Squad])>-10) { 
			echo "<a HREF='./edit.php?id=".$row_array[Cislo]."' rel=\"modal:open\" title='Upravit závodníka'><img src=\"../images/edit.png\"></a>";
			echo "<a href='./reg-email.php?id=".$row_array[Cislo]."' class='regemail' rel=\"modal:open\" title='Poslat závodníkovi registrační email'><img src=\"../images/mail.png\"></a>";
			if ($row_array[Zaplaceno]!=="on") {
				echo "&nbsp;&nbsp;&nbsp;<a href='./pay.php?id=".$row_array[Cislo]."&klic=$row_array[Klic]' rel=\"modal:open\" title='Označit jako ZAPLACENO / Potvrdit účast u prematche, RO nebo VIP'><img src=../images/confirm.png></a>";
				echo "&nbsp;&nbsp;&nbsp;<a href='./pay-email.php?id=".$row_array[Cislo]."' rel=\"modal:open\" title='Poslat závodníkovi upozornění na nezaplacení'><img src=\"../images/mail_alert.png\"></a>";
				echo "<a href='./pay.php?id=".$row_array[Cislo]."&klic=$row_array[Klic]&vyradit' rel=\"modal:open\" id=\"myModal\"title='Vyřadit závodníka'><img src=\"../images/cancel.png\"></a>";
			}
//			if (($ip=="81.2.196.33") or ($ip=="81.200.61.39")) {
			if ($user=="admin") {
			echo "&nbsp;&nbsp;&nbsp;<a href='./delete.php?id=".$row_array[Cislo]."' rel=\"modal:open\" title='Smazat závodníka'><img src=\"../images/delete.png\"></a>&nbsp;&nbsp;";
			}
        }
        echo "</td>";      
        echo "<td class='paymentdate payemail'>";
        if ($row_array[Zaplaceno]!=="on") {
          echo date('d.m.Y', strtotime($DatPay));
        }
        echo "&nbsp;</td>";
      }      
      echo "<TD class='$pole'>".$row_array[$i]."</TD>";	
		};
	};
echo "</TR>";
};
echo "</table>\n";

echo "<br><br>";
echo "<b>Vyúčtování</b><br>";
foreach ($sumaZaplaceno as $mena => $castka) {echo "- zaplaceno: $castka CZK"; }
?>

<br><br><br>
<b>LEGENDA</b><br>
- registrováno<br>
- rozhodčí a závodníci v prematchi neplatí (neposílá se urgence ani se automaticky nevyřadí)<br>
- <span style="font-weight: bolder">duplicita</span><br>
- <span style="background-color: #9fff9f">zaplaceno (potvrzeno: RO, VIP)</span><br>
- <span style="color: #ffff00; background-color: #ff0000">nezaplaceno po limitu - urgence</span><br>
- <span style="color:#858585;background-color: #d3d3d3">vyřazeno</span><br><br>

<script>
var $rows = $('#registrationlist tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>

</BODY>
</HTML>