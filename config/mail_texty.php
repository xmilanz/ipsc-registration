<?php

include "db/dbconn.php";

$query = "SELECT * from match_config where Zavod_id='$table'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$match_data = mysql_fetch_array($result);

$email_registrace_platba_text="Dobrý den,

zaregistroval(a) jste se na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace Vás žádáme o úhradu registračního poplatku:
&nbsp;- účet: ".$match_data[Banka_ucet_cislo]."/".$match_data[Banka_ucet_kod]."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného. <strong>Registrace bez platby je platná do <span style=\"color:#ff0000;\">##DatPay##</span>.</strong> Po tomto termínu bude vaše registrace automaticky zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Po připsání platby na účet již není možné startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";


// reg mail v zavodu bez placeni predem
$email_registrace_zavod_bez_platby_predem="Dobrý den,

zaregistroval(a) jste se na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace se registrační poplatek ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]." platí před závodem na místě.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";
// reg mail v zavodu bez placeni predem

$email_registrace_bez_platby_text="Dobrý den,

zaregistroval(a) jste se na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Protože pomáháte při závodu nebo se jakýmkoliv jiným způsobem účastníte jeho organizace, nemusíte platit registrační poplatek :).

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_registrace_cekatel_text="Dobrý den,

zaregistroval(a) jste se jako čekatel na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Počkejte na uvolnění místa a zaslání informací o placení závodu. Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
";

// emaily zasilane automaticky pri regostraci nového zavodnika v administraci 

$email_registrace_cekatel_text_admin_novy_zavodnik="Dobrý den,

pořadatel závodu vás zaregistroval jako čekatele na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Počkejte na uvolnění místa a zaslání informací o placení závodu. Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
";

$email_registrace_platba_text_admin_novy_zavodnik="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace Vás žádáme o úhradu registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$match_data[Banka_ucet_cislo]."/".$match_data[Banka_ucet_kod]."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného. <strong>Registrace bez platby je platná do <span style=\"color:#ff0000;\">##DatPay##</span>.</strong> Po tomto termínu bude vaše registrace automaticky zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Po připsání platby na účet již není možné startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_registrace_bez_platby_text_admin_novy_zavodnik="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Protože pomáháte při závodu nebo se jakýmkoliv jiným způsobem účastníte jeho organizace, nemusíte platit registrační poplatek :). 

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_registrace_platba_na_miste_admin_novy_zavodnik="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Protože jste se s pořadatelem domluvil(a) na <strong>platbě na místě</strong>, nemusíte platit registrační poplatek před závodem.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";


// emaily zasilane z administrace pomoci tlacitka Odeslat registracni email

$email_registrace_cekatel_text_admin="Dobrý den,

znovu Vám posíláme registrační email závodu <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Počkejte na uvolnění místa a zaslání informací o placení závodu. Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
";

$email_registrace_cekatel_presun_platba="Dobrý den,

pořadatel Vás přesunul z čekatelů do ##Squad##. Posíláme Vám registrační email závodu <strong>$match_data[Zavod]</strong> s podklady pro zaplacení startovného.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace Vás žádáme o úhradu registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$match_data[Banka_ucet_cislo]."/".$match_data[Banka_ucet_kod]."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného. <strong>Registrace bez platby je platná do <span style=\"color:#ff0000;\">##DatPay##</span>.</strong> Po tomto termínu bude vaše registrace automaticky zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Po připsání platby na účet již není možné startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";


$email_registrace_platba_text_admin="Dobrý den,

znovu Vám posíláme registrační email závodu <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace Vás žádáme o úhradu registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$match_data[Banka_ucet_cislo]."/".$match_data[Banka_ucet_kod]."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného. <strong>Registrace bez platby je platná do <span style=\"color:#ff0000;\">##DatPay##</span>.</strong> Po tomto termínu bude vaše registrace automaticky zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Po připsání platby na účet již není možné startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_registrace_bez_platby_text_admin="Dobrý den,

znovu Vám posíláme registrační email závodu <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Protože pomáháte při závodu nebo se jakýmkoliv jiným způsobem účastníte jeho organizace, nemusíte platit registrační poplatek :). 

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_registrace_platba_na_miste_admin="Dobrý den,

znovu Vám posíláme registrační email závodu <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

Protože jste se s pořadatelem domluvil(a) na <strong>platbě na místě</strong>, nemusíte platit registrační poplatek před závodem.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";


// novy zavodnik registrovany adminem v zavodu bez placeni predem
$email_registrace_zavod_bez_platby_predem_admin="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$match_data[Zavod]</strong>.
Datum závodu: $match_data[Zavod_datum].

##STRELEC##

V souladu s pravidly registrace se registrační poplatek ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]." platí před závodem na místě.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <strong>\"zrušit účast\"</strong> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";
// novy zavodnik registrovany adminem v zavodu bez placeni predem


$email_urgence_platba_text_admin="Dobrý den,

dne ##DatReg## jste se zaregistroval(a) na závod <strong>$match_data[Zavod]</strong>.

##STRELEC##
Do dnešního dne nedošlo k úhradě platby za registraci na výše uvedený závod. <strong><span style=\"color:#ff0000;\">V souladu s pravidly registrace vyprší ##DatPay##.</span></strong> Pokud jste již platbu provedli, prosíme o zaslání potvrzení. 

Nedojde-li v nejbližší době k úhradě, bude vaše registrace vyřazena z aktuálního squadu a nahrazena jiným zájemcem z řad čekatelů. <strong>Vaše účast v závodě poté není garantována!</strong> 

Údaje pro platbu
&nbsp;- účet: ".$match_data[Banka_ucet_cislo]."/".$match_data[Banka_ucet_kod]."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$match_data[Banka_ucet_CASTKA]." ".$match_data[Banka_ucet_MENA]."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";


$email_text_platba="Dobrý den,

zaevidovali jsme úhradu registračního poplatku závodu <strong>$match_data[Zavod]</strong>. 

##STRELEC##
Těšíme se na brzkou viděnou na závodě.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel registrace
Po připsání platby na účet již nelze startovné vrátit, v souladu s pravidly závodu je však možné jej přenést na jiného závodníka, <strong>nejpozději však v den prematche.</strong>
Přesuny závodníků mezi squady na základě jejich žádosti je možné provádět <strong>nejpozději do 30 minut před oficiálním zahájením hlavního závodu</strong>.
</i></small>
";

$email_text_vyrazeni_automaticke="Dobrý den,

protože nedošlo k zaplacení registračního poplatku v řádném termínu, byl(a) jste vyřazen(a) ze závodu <strong>$match_data[Zavod]</strong>. Pokud jste již platbu provedli, prosíme o zaslání potvrzení. 

<strong>Vaše registrace byla zrušena.</strong>

##STRELEC##

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
<i><small>
------
Výpis z pravidel pro úhradu startovaného
Startovné uhraďte tak, aby platba proběhla do 10 dnů od registrace.
U závodníků zaregistrovaných méně jak 10 dní před závodem je třeba startovné zaplatit nejpozději jeden den před prematchem.
V případě neuhrazení startovného v řádném termínu bude Vaše registrace zrušena (neplatí pro organizátory, pomocníky a rozhodčí).
</i></small>
";

$email_text_vyrazeni_admin="Dobrý den,

pořadatel závodu vás vyřadil ze závodu <strong>$match_data[Zavod]</strong>. 

<strong>Vaše registrace byla zrušena.</strong>

##STRELEC##

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
";

$email_text_vyrazeni_vlastni="Dobrý den,

prostřednictvím odkazu z potvrzovacího emailu jste se vyřadil(a) ze závodu <strong>$match_data[Zavod] [".$match_data[Zavod_misto]."]</strong>. Pokud jste tuto akci neprovedli, neprodleně nás kontaktujte v odpovědi na tento email.

<strong>Vaše registrace byla zrušena.</strong> 

##STRELEC##

S pozdravem
<strong>$match_data[Zavod_poradatel]</strong>
";
?>