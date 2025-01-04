<HTML>
<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico"/>
    <title>KPS Eggenberg - administrace registrace závodu <?php echo "$zavod"; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
</HEAD>
<BODY>

<?php 
echo "<h3 class='nadpis'>..: Závodník ". $_POST["prijmeni"]." ".$_POST["jmeno"]." :..</h3>";

// kontrola zadanych udaju
if ($_POST[alias]==""){
    echo "<p style=\"color: red; font-weight:bold; font-size:15px;\">Nevyplnili jste aias</p>";
    echo "<br>";
    echo "<button style=\"background-color: red; color:white; padding:5px; font-weight:bold; cursor:pointer;\" onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět na editaci</button>\n";
  $chyba=1;
};

if ($_POST[prijmeni]==""){
    echo "<p style=\"color: red; font-weight:bold; font-size:15px;\">Nevyplnili jste příjmení</p>";
    echo "<br>";
    echo "<button style=\"background-color: red; color:white; padding:5px; font-weight:bold; cursor:pointer;\" onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět na editaci</button>\n";
  $chyba=1;
};

if ($_POST[jmeno]==""){
    echo "<h3 style=\"color: red;\">Nevyplnili jste jméno</h3>";
    echo "<br>";
    echo "<button style=\"background-color: red; color:white; padding:5px; font-weight:bold; cursor:pointer;\" onclick=\"window.location.href = 'javascript:history.go(-1)';\">Zpět na editaci</button>\n";
  $chyba=1;
};

$serie=0;
//echo ":serie:".$_POST[serie].":";
if (isset($_POST["serie"])=="on") {
  $serie=1;
}

// pokud je vse v poradku;
if ($chyba<>"1"){
    include ("auth.php");
    include ("./db/dbconn.php");

    $alias=trim(mb_convert_case($_POST[alias], MB_CASE_UPPER, "UTF-8"));
    $prijmeni=trim(mb_convert_case($_POST[prijmeni], MB_CASE_TITLE, "UTF-8")).$_POST[prijmeni_stav].'';
    $prijmeni=ucfirst(strtolower($prijmeni));
    $jmeno=trim(mb_convert_case($_POST[jmeno], MB_CASE_TITLE, "UTF-8"));

//if ($_POST["RO"]=="on") {
//  $RO=1;
//}

$query="UPDATE ".$table." SET 
    Alias='$alias',
    Prijmeni='$prijmeni',
    Jmeno='$jmeno',
    Region='$_POST[region]',
    Mail='$_POST[email]',
    Kategorie='$_POST[kategorie]',
    Pidiv='$_POST[pidiv]',
    Pifak='$_POST[pifak]',
    Squad='$_POST[squad]',
    Poznamka='$_POST[poznamka]',
    RO='$_POST[RO]',
    VIP='$_POST[VIP]',
    Potvrzeno='$_POST[Potvrzeno]'
  WHERE CISLO='$_POST[cislo]'";

$result = mysql_query($query);
if (!$result) {
    echo "<center>";
    echo"<FONT COLOR=RED>Při vkládání do databáze došlo k chybě. Zkuste to později.</FONT><BR><BR>\n";
    echo "<span style='font-family:courier;'>MySQL Error: ". mysql_error();"</span>";
    echo "<br><br><br><button style=\" padding:3px; cursor:pointer;\" onclick=\"self.close();window.opener.location.reload(false);\">Zavřít okno</button>\n";
    echo "</center>";
die();
}
else {
    header("refresh:0;url=index.php");
}

};
?>
</body>
</HTML>