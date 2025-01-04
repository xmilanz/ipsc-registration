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
    require_once ("./auth.php");
    require_once ("./db/dbconn.php");
?>

<h3 class='nadpis'>..: Nový závodník :..</h3>
<FORM class='edit_shooter' ACTION="./add.php" METHOD="post">

<?php
    $query = "SELECT Max(Cislo) FROM ".$table."";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    $line = mysql_fetch_row($result);
    echo "<INPUT TYPE=HIDDEN NAME=varsymbol VALUE=".$varsymbol.">";

   list($usec, $sec) = explode(" ", microtime());
   echo "<INPUT TYPE=HIDDEN NAME=datreg VALUE=".$sec.">";
?>
<span class="edit_shooter">Alias </span>
	<INPUT TYPE=TEXT NAME=alias id=""><BR>

<span class="edit_shooter">Příjmení </span>
	<INPUT TYPE=TEXT NAME=prijmeni id=""><BR>

<span class="edit_shooter">Jméno </span>
	<INPUT TYPE=TEXT NAME=jmeno VALUE=""><BR>

<span class="edit_shooter">Doplnění jména </span>
	<select name=prijmeni_stav>
	 <option value=""></option>
	 <option value=" ml.">ml.</option>
	 <option value=" st.">st.</option>
	</select>
<BR>

<span class="edit_shooter">E-mail </span>
	<INPUT TYPE=TEXT NAME=email VALUE=""><BR>

<span style="display:none;"class="edit_shooter">Region </span>
	<INPUT TYPE=HIDDEN NAME=region VALUE="CZE"><BR>

<span class="edit_shooter">Pistol Divize </span>
	<select name=pidiv>
	  <option value="PRD">Production - PRD</option>
	  <option value="STD">Standard  - STD</option>
	  <option value="OPN">Open - OPN</option>
	  <option value="REV">Revolver - REV</option>
	  <option value="CLA">Classic - CLA</option>
	  <option value="PDO">Production Optics - PDO</option>
	</select>
<BR>

<span class="edit_shooter">Kategorie </span>
	<select name=kategorie>
      <option value=REGULAR>Regular (běžná)</option>
      <option value=JUNIOR>Junior (do 21 let)</option>
      <option value=LADY>Lady (ženy)</option>
      <option value=SENIOR>Senior (nad 50 let)</option>
      <option value=SSENIOR>Super Senior (nad 60 let)</option>
	</select>
<BR>

<span class="edit_shooter">Pistole Faktor </span>
	<select name=pifak>
	  <option value=MIN>Minor - Min</option>
	  <option value=MAJ>Major - Maj</option>
	</select>
<BR>

<span class="edit_shooter">Squad </span>
	<select name=squad>
      <option value=0>Prematch RO</option>
      <option value=1>1</option>
      <option value=2>2</option>
      <option value=3>3</option>
      <option value=4>4</option>
      <option value=5>5</option>
      <option value=6>6</option>
      <option value=7>7</option>
      <option value=8>8</option>
	</select>
<BR>

<span class="edit_shooter">Rozhodčí</span>
	<INPUT TYPE=checkbox NAME=RO>
<BR>
<span class="edit_shooter">VIP</span>
	<INPUT TYPE=checkbox NAME=VIP>
<BR><BR>

<span class="edit_shooter">Poznámka </span>
	<INPUT TYPE=TEXT NAME=poznamka SIZE=20 VALUE="">
<BR>

<br>
<center>
<INPUT style="background-color: green; width:auto; position: relative; left: 0px;color:white; font-size: 13px;  border: 0px; padding:5px; font-weight:bold; cursor:pointer; " type="submit" value="Přidat" >
&nbsp;&nbsp;<a href="#" rel="modal:close"><button style=" padding:3px; cursor:pointer; font-size: 13px;">Zavřít</button></a>
</center>



</FORM>
</CENTER>

</body>
</html>