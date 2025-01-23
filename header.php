<?php

if (file_exists('./db/dbconn.php')) {
    require_once './db/dbconn.php';
} elseif (file_exists('../db/dbconn.php')) {
    require_once '../db/dbconn.php';
}

require_once './config/data.php';

$dnes=date_format(new DateTime(),"Y-m-d H:i:s");

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);

if ($match_data[Payment_before]=="") {
   $paymentBeforeClass=" d-none";
}

if ($match_data[Web_zobrazovat_situace]=="") {
   $ZobrazovatSituaceClass=" d-none";
}

if ($match_data[Web_zobrazovat_aliasy]=="") {
   $ZobrazovatAliasyClass=" d-none";
}

// nastaveni poradatele pro soubor stylů
if ((strpos($match_data[Zavod_poradatel], 'Eggenberg') | strpos($match_data[Zavod_poradatel],'EGGENBERG') || strpos($match_data[Zavod_poradatel],'eggenebrg')) !== false) {
	$poradatel="eggenberg";
	$sponzor="<a href='https://www.mujnuz.cz/' target='_blank'><img src='./images/mujnuz.png' class='img-thumbnail mb-3 mx-auto d-block' alt='Můj nůž.cz'></a>";
}
elseif ((strpos($match_data[Zavod_poradatel], 'Pelhřimov') || strpos($match_data[Zavod_poradatel], 'PELHŘIMOV') || strpos($match_data[Zavod_poradatel], 'pelhřimov') || strpos($match_data[Zavod_poradatel], 'Pelhrimov') || strpos($match_data[Zavod_poradatel], 'PELHRIMOV') || strpos($match_data[Zavod_poradatel], 'pelhrimov')) !== false) {

	$poradatel="pelhrimov";
	$sponzor="<a href='http://www.jankruta.cz/' target='_blank'><img src='./images/jan_kruta.gif' width='30%' class='img-thumbnail mb-3 mx-auto d-block' alt='Jan Krůta'></a>";
}
else {
	$poradatel="";
	$sponzor="";
}

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs"">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo "$match_data[Zavod]"; ?></title>
    <link rel="shortcut icon" href="./images/favicon.ico" />
	<link rel="apple-touch-icon" href="./images/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="./images/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="./images/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="./images/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="./images/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="./images/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="./images/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="./images/apple-touch-icon-152x152.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon-180x180.png" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed%3A400%2C700%7CArimo%3A400%2C700&#038;ver=eb423f0ac3bea64e1037184f3b727fe6" type="text/css" media="all" />
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- bootstrap -->
	<link rel="stylesheet" href="./styles/style.css">
	<link rel="stylesheet" href="./styles/style_<?php echo "$poradatel" . ".css"; ?>">
<!-- gallery -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<!-- gallery  -->
</head>
<body>
<div class="container">

<div class="header">
	<div class="header-logo">
		<img src="./images/logo-header-dvc.png" alt="Logo">
		<div class="text-over-image">
			<a class="logo-text" href="<?php echo "$match_data[Klub_web]"; ?>" target="_blank">
				<p class="mt-2"><?php echo "$match_data[Zavod]<br>";?></a></p>
		</div>
	</div>
</div>

<nav class="navbar navbar-expand-md sticky-top navbar-dark">
    <a href="index.php"><span class="fas fa-home navbar-toggler" style="font-size:20px"></span></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav font-weight-bold">
    <li class="nav-item">
      <a class="nav-link" href="./">Propozice</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./registrace.php">Registrace</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./zavodnici.php">Závodníci</a>
    </li>
    <li class="nav-item <?php echo "$ZobrazovatSituaceClass"; ?>">
      <a class="nav-link" href="./situace.php">Situace</a>
    </li>
    <li class="nav-item <?php echo "$ZobrazovatAliasyClass"; ?>">
      <a class='nav-link' href='./kontrola_aliasu.php'>Aliasy</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $match_data[Zavod_vysledky];?>">Výsledky</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./login.php">&nbsp<i class='fas fa-user-lock' style='font-size:16px'></i>&nbsp;</a>
    </li>
  </ul>
  </div>
</nav>

<div id="main">
	<div id="content">