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
    Alias varchar(16),
    Prijmeni varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Jmeno varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    ZP varchar(255),
    Region varchar(3),
    Kategorie varchar(20),
    Divize varchar(3),
    Faktor varchar(3),
    Squad varchar(3),
    SquadReg varchar(3),
    Staff varchar(3),
    Mail varchar(40),
    Poznamka varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    DatReg varchar (11),
    DatPay varchar (11),
    RegistraceIP varchar (50),
    Urgence varchar(255),
    Zaplaceno varchar(3),
    ZaplatiNaMiste varchar(3),
    DatumZaplaceni varchar(255),
    VarSym varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
    klic int(11) NOT NULL DEFAULT '0',
    OdeslanRegMail varchar(3),
    Vyrazeno varchar(255),
    VyrazenoIP varchar(50),
    Castka float(9,2),
    Mena varchar(3),
    Zavod varchar(25)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";  
  break;

  case "match_config":
    echo "Vytvarim tabulku [match_config] ...";
    $query="CREATE TABLE match_config (
    Zavod_id varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_datum varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_cas_registrace varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '18:00:00',
    Zavod_zacatek_registrace int(3) DEFAULT '10',
    Zavod_konec_registrace int(3) DEFAULT '10',
    Zavod_registrace_pozastaveno varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_more_divisions varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_zbrojni_prukaz varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_zobrazovat_sponzory varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Web_zobrazovat_situace varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Web_zobrazovat_aliasy varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_cas_prematch varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '13:00 - 17:00',
    Zavod_cas_prezence varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '8:00 - 9:00',
    Zavod_cas_main varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '9:00 - 14:00',
    Zavod_cas_main_dopoledne varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_cas_main_odpoledne varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_misto varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_misto_mapa varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_poradatel varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Klub praktické střelby EGGENBERG',
    Zavod_poradatel_adresa varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Heydukova 514/23, České Budějovice 7, 370 01 České Budějovice',
    Zavod_match_director varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Jan Hátle',
    Zavod_email_poradatel varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'jan.hatle1@gmail.com',
    Zavod_telefon_poradatel varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 724 521 364',
    Zavod_range_master varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Ondřej Bárta',
    Zavod_email_range_master varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_telefon_range_master varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 777 154 158',
    Zavod_stats varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Milan Žídek',
    Zavod_email_stats varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'statistik@kps-eggenberg.cz',
    Zavod_telefon_stats varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zavod_hospodar varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Antonín Liška',
    Zavod_email_hospodar varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'antoni.liska@seznam.cz',
    Zavod_telefon_hospodar varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '+420 777 286 040',
    Zavod_email_from varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'registrace@kps-eggenberg.cz',
    Zavod_stages int(2) DEFAULT '8',
    Zavod_min_pocet_ran int(3),
    Zavod_pocet_dni_na_platbu int(2) DEFAULT '10',
    Zavod_vysledky varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'https://www.ipsc.zone/v2/results.php',
    Squad_prem_max int(3) DEFAULT '30',
    Squad_main_max int(3) DEFAULT '10',
    Banka_ucet_CASTKA int(3),
    Banka_ucet_MENA varchar(3) DEFAULT 'CZK',
    Banka_ucet_cislo varchar(20) DEFAULT '296257146',
    Banka_ucet_kod varchar(4) DEFAULT '0300',
    Banka_nazev varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Československá obchodní banka, a. s.',
    Banka_adresa varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Praha 5, Radlická 333/150, PSČ 150 57',
    Klub_web varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'https://www.kps-eggenberg.cz',
    GDPR_spravce varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Klub praktické střelby EGGENBERG, IČ 26524597',
    Payment_before varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'on',
    PRIMARY KEY (Zavod_id)
    )";

    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
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
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
  break;

  case "nastaveni":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    parId int(4)AUTO_INCREMENT PRIMARY KEY,
    parName varchar(20) UNIQUE not null,
    parValue varchar(50),
    parValueI FLOAT(9,3),
	parNote1 varchar(100) DEFAULT NULL,
	parNote2 varchar(100) DEFAULT NULL
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
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
  break;

  case "divisions":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    Id int(4)AUTO_INCREMENT PRIMARY KEY,
    Name varchar(4) UNIQUE not null,
    Value varchar(50)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK <br/>";
    $query="insert into $dbcreateTable (Name,Value) values
	('PRD', 'Production'),
	('STD', 'Standard'),
	('OPN', 'Open'),
	('CLA', 'Classic'),
	('REV', 'Revolver'),
	('REV6', 'Revolver šestiraňák'),
	('PDO', 'Production Optics'),
	('SDO', 'Standard Optics'),
	('PCC', 'Pistol Caliber Carbines'),
	('PCCI', 'PCC Iron'),
	('PCCO', 'PCC Optics'),
	('MR', 'Mini Rifle'),
	('MRS', 'Mini Rifle Standard'),
	('MRO', 'Mini Rifle Open');
	";
    echo "Plním data do tabulky [$dbcreateTable] ...";
    $result = mysql_query($query);
    if (!$result) {
       die('chyba vlozeni vychozich hodnot: ' . mysql_error());
    };
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
  break;

  case "categories":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    Id int(4)AUTO_INCREMENT PRIMARY KEY,
    Name varchar(16) UNIQUE not null
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK <br/>";
    $query="insert into $dbcreateTable (Name) values
	('REGULAR'),
	('SENIOR'),
	('SSENIOR'),
	('GSENIOR'),
	('LADY'),
	('LSENIOR'),
	('JUNIOR'),
	('SJUNIOR');
	";
    echo "Plním data do tabulky [$dbcreateTable] ...";
    $result = mysql_query($query);
    if (!$result) {
       die('chyba vlozeni vychozich hodnot: ' . mysql_error());
    };
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
  break;

  case "squads":
    echo "Vytvarim tabulku [$dbcreateTable] ...";
    $query="CREATE TABLE ".$dbcreateTable." (
    Id int(4)AUTO_INCREMENT PRIMARY KEY,
    Number varchar(3) UNIQUE not null,
    Name varchar(50)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK <br/>";
    $query="insert into $dbcreateTable (Number,Name) values
	('-9', 'VYŘAZENO'),
	('-2', 'Čekatelé'),
	('100', 'Prematch'),
	('101', 'Squad 101'),
	('102', 'Squad 102'),
	('103', 'Squad 103'),
	('104', 'Squad 104'),
	('105', 'Squad 105'),
	('106', 'Squad 106'),
	('107', 'Squad 107'),
	('108', 'Squad 108');
	";
    echo "Plním data do tabulky [$dbcreateTable] ...";
    $result = mysql_query($query);
    if (!$result) {
       die('chyba vlozeni vychozich hodnot: ' . mysql_error());
    };
    echo "<strong>OK - pokracujte klavesou F5</strong><br/>";
  break;
}

?>
