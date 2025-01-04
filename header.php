<?php
include "./config/data.php";

$dnes=date_format(new DateTime(),"j.n.Y H:i:s");
$zavod_start=date_format(new DateTime($zavod_datum),"j.n.Y H:i:s");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs"">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='//fonts.googleapis.com/css?family=Roboto+Condensed%3A400%2C700%7CArimo%3A400%2C700&#038;ver=eb423f0ac3bea64e1037184f3b727fe6' type='text/css' media='all' />
    <link rel="shortcut icon" href="https://www.kps-eggenberg.cz/images/favicon.ico" />
    <title><?php echo $web_title;?></title>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel='stylesheet' href='https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- bootstrap -->
	<link rel="stylesheet" href="./styles/style.css">
<!-- gallery -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<!-- gallery  -->
</head>
<body>
<div class="container">
<div id="header">
	<div id="header-logo"><a href="https://www.kps-eggenberg.cz/"><img src="https://www.kps-eggenberg.cz/images/logo.png" alt="Klub praktické střelby Eggenberg"></a></div>
</div>
<nav class="navbar navbar-expand-md sticky-top navbar-dark">
    <a href="index.php"><span class="fas fa-home navbar-toggler" style="font-size:20px"></span></a>
	<a href="#" class="navbar-brand order-md-last order-0"><?php echo $zavod;?></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav font-weight-bold">
    <li class="nav-item">
      <a class="nav-link" href="./">Propozice</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="https://www.kps-eggenberg.cz/" id="navbardrop" data-toggle="dropdown">Registrace</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="./registrace.php">Registrovat se na závod</a>
        <a class="dropdown-item" href="./kontrola_aliasu.php">Kontrola aliasů série</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./zavodnici.php">Závodníci</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./situace.php">Situace</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="https://www.kps-eggenberg.cz/vysledky-eggenberg-cup.php">Výsledky</a>
    </li>
  </ul>
  </div>
</nav>

<div id="main">
	<div id="content">
