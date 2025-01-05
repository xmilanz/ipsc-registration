<?php

if (!isset($dbcreateParam)) {
  $dbcreateParam="hlavni";
  $tableCreate=$table;
}

switch ($dbcreateParam) {
  case "hlavni":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    Cislo int(4)AUTO_INCREMENT PRIMARY KEY,
    Prijmeni varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Jmeno varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Region varchar(3),
    Pidiv varchar(3),
    Kategorie varchar(20),
    Squad varchar(3),
    Pifak varchar(3),
    VarSym varchar(5) UNIQUE,
    Mail varchar(40),
    Poznamka varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zaplaceno varchar(3),
    DatReg varchar (11)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK - pokracujte klavesou F5<br/>";  
  break;

  case "match_config":
    echo "Vytvarim tabulku [match_config] ...";
    $query="CREATE TABLE match_config (
    Zavod_id varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_datum varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_cas_prematch varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '13:00 - 17:00',
    Zavod_cas_prezence varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '8:00 - 9:00',
    Zavod_cas_main varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '9:00 - 14:00',
    Zavod_cas_main_dopoledne varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_cas_main_odpoledne varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_misto varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'střelnice Opařany',
    Zavod_poradatel varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Klub praktické střelby EGGENBERG',
    Zavod_match_director varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Jan Hátle',
    Zavod_email_poradatel varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'jan.hatle1@gmail.com',
    Zavod_telefon_poradatel varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 724 521 364',
    Zavod_range_master varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Ondřej Bárta',
    Zavod_email_range_master varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_telefon_range_master varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 777 154 158',
    Zavod_stats varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Milan Žídek',
    Zavod_email_stats varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_telefon_stats varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_match_hospodar varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Antonín Liška',
    Zavod_email_hospodar varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'antoni.liska@seznam.cz',
    Zavod_telefon_hospodar varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 777 286 040',
    Zavod_email_from varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'registrace@kps-eggenberg.cz',
    Zavod_stages int(2) DEFAULT '8',
    Zavod_min_pocet_ran int(3) DEFAULT '135',
    Zavod_pocet_dni_na_platbu int(2) DEFAULT '10',
    Zavod_pocet_dni_do_vyrazeni int(2) DEFAULT '13',
    Zavod_vysledky varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'https://ipsc.zone/results',
    Squad_prem_max int(3) DEFAULT '30',
    Squad_main_max int(3) DEFAULT '10',
    Banka_ucet_CASTKA int(3) DEFAULT '900',
    Banka_ucet_MENA varchar(3) DEFAULT 'CZK',
    Banka_ucet_cislo varchar(20) DEFAULT '296257146',
    Banka_ucet_kod varchar(4) DEFAULT '0300',
    Klub_web varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'https://www.kps-eggenberg.cz',
    GDPR_spravce varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Klub praktické střelby EGGENBERG, IČ 26524597',
    Payment_before varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'on',
    PRIMARY KEY (Zavod_id)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK - pokracujte klavesou F5<br/>";
  break;

  case "site_admins":
    echo "Vytvarim tabulku [site_admins] ...";
    $query="CREATE TABLE site_admins (
    id int(4)AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci',
    password varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci',
    email varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci',
    firstname varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci',
    lastname varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci'
    PRIMARY KEY (id)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK - pokracujte klavesou F5<br/>";
  break;

  case "nastaveni":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    parId int(4)AUTO_INCREMENT PRIMARY KEY,
    parName varchar(20) UNIQUE not null,
    parValue varchar(50),
    parValueI FLOAT(9,3)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK <br/>";
    $query="insert into $dbcreateTable (parName,parValueI) values ('dbver',1.1)";
    echo "Plním data do tabulky [$dbcreateTable] ...";
    $result = mysql_query($query);
    if (!$result) {
       die('chyba vlozeni vychozich hodnot: ' . mysql_error());
    };
    echo "OK - pokracujte klavesou F5<br/>";
  break;
}

?>
