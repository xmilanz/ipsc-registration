<?php
//error_reporting(64);
ini_set('display_errors',0);
error_reporting(E_WARNING);

require_once '../config/data.php';

//echo $db_host."-".$db_login."-".$db_pass."-".$db_dtb."<br/>";
$mysql = mysql_connect($db_host, $db_login, $db_pass) or die('Could not connect: ' . mysql_error());
mysql_select_db($db_dtb) or die('Could not select database');

mysql_query("SET NAMES utf8;");
mysql_query("SET CHARACTER_SET utf8;");

if ($_GET["recreate"]) {
  $query="drop table $table;";
  mysql_query($query);
  $query="drop table $table_nastaveni;";
  mysql_query($query);

}

require_once './functions.php';

$result = mysql_query("SHOW TABLES LIKE '".$table."'");
if (mysql_num_rows($result)==0) {
  $dbcreateParam="hlavni";
  $dbcreateTable=$table;
  require_once ("dbcreate.php");
}

$result = mysql_query("SHOW TABLES LIKE '".$table_nastaveni."'");
if (mysql_num_rows($result)==0) {
  $dbcreateParam="nastaveni";
  $dbcreateTable=$table."_nastaveni";
  require_once ("dbcreate.php");
}

// aktualizace klicu - query presunuta do registrovat.php
//$result = mysql_query("update $table set klic= FLOOR(10 + (RAND(Cislo) * 9000)) where klic is null or klic=0;");


$dbver=0;
$result = mysql_query("select parName,parValueI from ".$table_nastaveni." where parName='dbver' LIMIT 1;");
if (mysql_num_rows($result)==1) {
  $z=mysql_fetch_array($result);
  $dbver=$z[parValueI];
}

if ($dbver<2) {
  require_once 'dbupdate2.php';
}
if ($dbver<2.1) {
  require_once 'dbupdate2_1.php';
}
if ($dbver<2.2) {
  require_once 'dbupdate2_2.php';
}
if ($dbver<2.3) {
  require_once 'dbupdate2_3.php';
}
if ($dbver<2.4) {
  require_once 'dbupdate2_4.php';
}
if ($dbver<2.5) {
  require_once 'dbupdate2_5.php';
}
if ($dbver<2.6) {
  require_once 'dbupdate2_6.php';
}
if ($dbver<2.7) {
  require_once 'dbupdate2_7.php';
}
if ($dbver<2.8) {
  require_once 'dbupdate2_8.php';
}
?>