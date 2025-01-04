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

$sql="DELETE FROM ".$table." WHERE Cislo=".$_GET[id];
$result = mysql_query($sql);

if (!$result) {
   echo 'MySQL Error: ' . mysql_error();
   exit;
}
if ($result) {
    echo "<h3 class='nadpis'>..: Mazání závodníka :..</h3>";
    echo "<center>";
    echo "<p><strong>Záznam číslo ".$_GET[id]." byl uspěšně vymazán</p></strong>";
    echo "<BR>";
    echo "<a href=\"index.php\" onclick=\"window.location.reload(true);\"><button style=\" padding:3px; cursor:pointer;\">Zavřít</button></a></center>";
    echo "</center>";
  exit;
}
?>
</body>
</html>