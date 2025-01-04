<?php 
include "header.php"; 

$zavod_day = date('l', strtotime($match_data[Zavod_datum]));
switch ($zavod_day) {
    case 'Monday': $zavod_day = "pondělí"; break;
    case 'Tuesday': $zavod_day = "úterý"; break;
    case 'Wednesday': $zavod_day = "středa"; break;
    case 'Thursday': $zavod_day = "čtrtek"; break;
    case 'Friday': $zavod_day = "pátek"; break;
    case 'Saturday': $zavod_day = "sobota"; break;
    case 'Sunday': $zavod_day = "neděle"; break;
}
$zavod_den= $zavod_day;

$prematch_datum = date('j.n.Y', strtotime($match_data[Zavod_datum] . ' -1 day'));
$prematch_day = date('l', strtotime($prematch_datum));
switch ($prematch_day) {
    case 'Monday': $prematch_day = "pondělí"; break;
    case 'Tuesday': $prematch_day = "úterý"; break;
    case 'Wednesday': $prematch_day = "středa"; break;
    case 'Thursday': $prematch_day = "čtrtek"; break;
    case 'Friday': $prematch_day = "pátek"; break;
    case 'Saturday': $prematch_day = "sobota"; break;
    case 'Sunday': $prematch_day = "neděle"; break;
}

$prematch_den= $prematch_day;
if ($match_data[Payment_before]=="") {
   $platba_na_miste="<strong>(úhrada na místě)</strong>";
	}
else {
	$platba_na_miste="";
}
?>
<div class="row">
	<div class="col-md-5">
	<div class="article">
	<div class="jumbotron"><H3>Základní informace</H3></div>
		<dl class="row  text-left">
			<dt class="col-4 text-right pr-0">Název závodu:</dt><dd class="col-8 pl-2 font-weight-bold text-uppercase"><?php echo "$match_data[Zavod]";?></dd>
			<dt class="col-4 text-right pr-0">Datum:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_datum]";?></dd>
			<dt class="col-4 text-right pr-0">Obtížnost:</dt><dd class="col-8 pl-2">IPSC Level I.</dd>
			<dt class="col-4 text-right pr-0">Počet situací:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_stages]";?></dd>
			<dt class="col-4 text-right pr-0">Min. počet ran:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_min_pocet_ran]";?></dd>
			<dt class="col-4 text-right pr-0">Prematch:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Squad_prem_max]";?> závodníků</dd>
			<dt class="col-4 text-right pr-0">Hlavní závod:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_stages]" * "$match_data[Squad_main_max]";?> závodníků</dd>
			<dt class="col-4 text-right pr-0">Pořadatel:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_poradatel]";?></dd>
			<dt class="col-4 text-right pr-0">Místo: </dt><dd class="col-8 pl-2"><?php echo "$match_data[Zavod_misto]";?>&nbsp;&nbsp;<a href='https://goo.gl/maps/ehm6pwDKJbPsvSpB6' target='_new'><i class='fas fa-crosshairs text-dark'></i></a>&nbsp;&nbsp;<a href='https://www.google.cz/maps/dir//Shooting+Club+Opa%C5%99any,+Opa%C5%99any+372,+391+61+Opa%C5%99any/@49.4014151,14.4730687,1641m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x470ca05e2e879acf:0xdfe1c002d0d9509b!2m2!1d14.4692126!2d49.4000376' target='_new'><i class='fas fa-route text-dark'></i></a></dd>
			<dt class="col-4 text-right pr-0">Startovné:</dt><dd class="col-8 pl-2"><?php echo "$match_data[Banka_ucet_CASTKA] $match_data[Banka_ucet_MENA] $platba_na_miste";?></dd>
		</dl>
	</div>
	</div>

	<div class="col-md-7">
	<div class="article">
		<div class="jumbotron"><H3>Sponzoři závodu</H3></div>
		<a href="https://www.mujnuz.cz/" target="_blank"><img src="./images/mujnuz.png" class="img-thumbnail mb-3 mx-auto d-block" alt="Můj nůž.cz"></a>
		<!--a href="http://www.jankruta.cz/" target="_blank"><img src="https://shoot79.webnode.cz/_files/200000069-7d9437e8c7/kondor.gif" width="30%" class="img-thumbnail mb-3 mx-auto d-block" alt="Jan Krůta"></a-->
		<div class="border border-left-0 border-right-0 border-bottom-0 border-info"></div>
		<div class="jumbotron"><H3>Bezpečnost</H3></div>
			<ol class="text-danger pr-2 text-left">
				<li>Jakákoliv manipulace se zbraní mimo stanoviště je zakázaná.</li>
				<li>zbraň musí být v pouzdru / v zavazadle / vybitá se spuštěným kohoutem.</li>
				<li>Střelec smí vyjmout zbraň z pouzdra pouze na stanovišti na na povel rozhodčího nebo na místě k tomu účelu speciálně určeném = BEZPEČNOSTNÍ  ZÓNA. V bezpečnostní zóně je zakázaná manipulace se střelivem.</li>
			</ol>
				<p class="text-center font-weight-bold text-danger pb-2">Jakékoliv porušení zásad bezpečnosti znamená okamžitou DISKVALIFIKACI!!!</p>
	</div>
	</div>
</div>

<div class="row my-3">
	<div class="col-md-5">
	<div class="article">
	<div class="jumbotron"><H3>Vedení závodu</H3></div>
		<dl class="row  text-left">
			<dt class="col-4 text-right pr-0">Match director:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_match_director]";?></dd>
			<dt class="col-4 text-right pr-0">Email:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_email_poradatel]";?></dd>
			<dt class="col-4 text-right pr-0">Telefon:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_telefon_poradatel]";?></dd>
			<dt class="col-4 text-right pr-0">Range Master:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_range_master]";?></dd>
			<dt class="col-4 text-right pr-0">Statistik:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_stats]";?></dd>
			<dt class="col-4 text-right pr-0">Hospodář:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_hospodar]";?></dd>
			<dt class="col-4 text-right pr-0">Email:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_email_hospodar]";?></dd>
			<dt class="col-4 text-right pr-0">Telefon:</dt><dd class="col-6 pl-2"><?php echo "$match_data[Zavod_telefon_hospodar]";?></dd>
		</dl>
	</div>
	</div>

	<div class="col-md-7">
	<div class="article">
	<div class="jumbotron"><H3>Časový plán</H3></div>
		<table class="table table-borderless m-2">
			<tr><td><strong>Prematch</strong></td><td><?php echo "$prematch_den $prematch_datum";?></td><td><?php echo "$match_data[Zavod_cas_prematch]";?></td></tr>
			<tr><td><strong>Prezence</strong></td><td><?php echo "$zavod_den $match_data[Zavod_datum]";?></td><td><?php echo "$match_data[Zavod_cas_prezence]";?></td></tr>
			<tr><td><strong>Závod</strong></td><td><?php echo "$zavod_den $match_data[Zavod_datum]";?></td><td><?php echo "$match_data[Zavod_cas_main]";?></td></tr>
		</table>
	</div>
</div>
</div>



<div class="row my-3">
	<div class="col">
	<div class="article">
	<div class="jumbotron"><H3>Další informace</H3></div>
		<dl class="row  text-left">
			<dt class="col-2 text-right pr-1">Divize:</dt><dd class="col-9 pl-2">Open, Standard, Production, Production Optic, Classic, Revolver, Revolver 6</dd>
			<dt class="col-2 text-right pr-1">Kategorie:</dt><dd class="col-9 pl-2">Regular, Lady, Junior, Senior a Super Senior</dd>
			<dt class="col-2 text-right pr-1">Povinná výbava:</dt><dd class="col-9 pl-2">ochrana sluchu a zraku (sluchátka, brýle)</dd>
			<dt class="col-2 text-right pr-1">Účast:</dt><dd class="col-9 pl-2">Držitelé zbrojního průkazu</dd>
			<dt class="col-2 text-right pr-1">Zbraně a střelivo:</dt><dd class="col-9 pl-2">Vlastní, jsou povoleny všechny druhy velkorážních pistolí a revolverů od ráže 9mm Luger (dle pravidel IPSC). Není povoleno používat střelivo s průbojnou a zápalnou střelou.</dd>
			<dt class="col-2 text-right pr-1">Občerstvení:</dt><dd class="col-9 pl-2">Zajištěno na střelnici </dd>
			<dt class="col-2 text-right pr-1">Poznámky:</dt><dd class="col-9 pl-2">
				Střelci startují na vlastní náklady nebo na náklady vysílající organizace, na vlastní nebezpečí. Střelci jsou odpovědní za způsobenou škodu a újmu.<br>
				Časový rozvrh je závislý na počtu účastníků závodu. Uvedený časový rozvrh je orientační.<br>
				Pořadatel si vyhrazuje právo změn dle vzniklých objektivních situací.</dd>
		</dl>
	</div>
	</div>
</div>

<div class="row my-3 <?php echo "$paymentBeforeClass"; ?> ">
	<div class="col-md-6">
	<div class="article">
	<div class="jumbotron"><H3>Úhrada startovného</H3></div>
		<ul class="pb-3  text-left">
			<li><i>Startovné uhraďte tak, aby platba proběhla do 10 dnů od registrace.
			<li>V případě neuhrazení startovného do 10 dnů, bude Vaše registrace smazaná.
			<li><b>Startovné je nevratné, ale lze přenést na jiného závodníka.
			<li>Při platbě za více závodníků uveďte pouze jedno číslo a o platbě informujte pořadatele <a href='mailto:<?php echo $match_data[Zavod_email_from] ?>'>e-mailem</A>.</b></i>
		</ul>
	</div>
	</div>

	<div class="col-md-6">
	<div class="article">
	<div class="jumbotron"><H3>Platební údaje</H3></div>
	<p class="text-monospace px-3  text-left">Číslo účtu: <?php echo "$match_data[Banka_ucet_cislo]/$match_data[Banka_ucet_kod]";?><br>
	Jméno příjemce: Klub praktické střelby EGGENBERG z.s.<br>
	Adresa příjemce: Heydukova 514/23, České Budějovice 7, 370 01 České Budějovice</p>

	<p class="text-monospace px-3 pb-3">Banka: Československá obchodní banka, a. s.<br>
	Adresa banky: Praha 5, Radlická 333/150, PSČ 150 57</p>
	</div>
	</div>
</div>


<div class="row my-3">
	<div class="col">
	<div class="article">
	<div class="jumbotron" role="button" data-toggle="collapse" href="#gdpr">
		<span class='d-flex justify-content-between'><H3>Souhlas se zpracováním osobních údajů </h3><i class='fas fa-arrows-alt-v' style='font-size:19px; color:#2a5a8e'>&nbsp;&nbsp;</i></span>
	</div>
	<div id="gdpr" class="collapse pr-3  pb-3">
	<ol>
		<li>Udělujete tímto dobrovolně souhlas pořadateli <?php echo "$match_data[GDPR_spravce]";?> (dále jen "Správce"), aby ve smyslu zákona č.101/2000 Sb., o ochraně osobních údajů (dále jen "zákon o ochraně osobních údajů") zpracovávala tyto osobní údaje:
			<ul>
				<li>jméno a příjmení</li>
				<li>datum narození</li>
				<li>e-mailová adresa</li>
				<li>telefonní číslo</li>
				<li>fotografie a videa z průběhu akce</li>
			</ul>
		</li>
		<li>Jméno, příjmení, datum narození, telefonní číslo, e-mailovou adresu a fotografie a videa z průběhu akce je nutné zpracovat:
			<ol type=\"a\">
				<li>za účelem registrace, evidence a vyhodnocení závodů který organizuje Správce.</li>
				<li>pro marketingové účely Správce, tj. zejména zveřejňování informací o průběžné činnosti Správce.</li>
			</ol>
		  <br>Tyto údaje budou Správcem zpracovávány po dobu 5 let ode dne udělení souhlasu.<br><br>
		</li>
		<li>S výše uvedeným zpracováním udělujete svůj výslovný souhlas a prohlašujete, že poskytnuté osobní údaje jsou pravdivé. Souhlas lze vzít kdykoliv zpět, zasláním emailu nebo dopisu Správci.</li><br>
		<li>Osobní údaje bude Správce zpracovávat manuálně nebo automaticky prostřednictvím svých zaměstnanců nebo dalších pořadatelů pověřených Správcem. Pro Správce mohou data zpracovávat případně i další poskytovatelé zpracovatelských softwarů, služeb a aplikací, které však v současné době Správce nevyužívá.</li><br>
		<li>Vezměte, prosíme, na vědomí, že podle zákona o ochraně osobních údajů máte právo:
			<ul>
				<li>vzít váš souhlas kdykoliv zpět,</li>
				<li>požadovat po nás informaci, jaké vaše osobní údaje zpracováváme,</li>
				<li>požadovat po nás vysvětlení ohledně zpracování osobních údajů,</li>
				<li>vyžádat si u nás přístup k těmto údajům a tyto nechat aktualizovat nebo opravit,</li>
				<li>požadovat po nás výmaz těchto osobních údajů,</li>
				<li>v případě pochybností o dodržování povinností souvisejících se zpracováním osobních údajů obrátit se na nás nebo na Úřad pro ochranu osobních údajů.</li>
			</ul>
		</li>
	</ol>
	</div>
	</div>
	</div>
</div>
<?php include "footer.php"; ?>
