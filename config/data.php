<?php
$table="table";

$table_nastaveni=$table."_nastaveni";
$table_config=$table."_config";
$table_divisions=$table."_divisions";
$table_categories=$table."_categories";
$table_squads=$table."_squads";

$admin_roles = array(
    "admin" => "přístup ke všem funkcím registračního systému", 
    "editor" => "nastavení závodu; správa závodníků; správa squadů, kategorií a divizí; export do PractiScore", 
    "vievew" => "zobrazení informací o závodníkovi; tisk seznamu závodníků, export seznamu do Excelu a PDF; export do PractiScore"
);

$db_host="host";
$db_login="login";
$db_pass="password";
$db_dtb="table";

// smtp autorizace
$smtp_username="username";
$smtp_password="password";
$smtp_server="server";
// smtp autorizace

$web_adresa="https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$web_adresa_admin = str_replace ('admin', '', $web_adresa) ;

$vyvojar="webdesign@milanz.org";
?>