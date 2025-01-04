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
    Poznamka varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Zaplaceno varchar(3),
    DatReg varchar (11)
    )";
    $result = mysql_query($query);
    if (!$result) {
       die('Invalid query: ' . mysql_error());
    };
    echo "OK <br/>";  
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
    echo "Plním data do tabulku [$dbcreateTable] ...";
    $result = mysql_query($query);
    if (!$result) {
       die('chyba vložení výchozích hodnot: ' . mysql_error());
    };
    echo "OK <br/>";
      
  break;
}

?>
