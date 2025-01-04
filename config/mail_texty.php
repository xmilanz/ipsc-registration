<?php
$email_registrace_platba_text="Dobrý den,

zaregistroval(a) jste se na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

V souladu s pravidly registrace Vás žádáme o zaslání registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$banka_ucet."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$banka_ucet_CASTKA." ".$banka_ucet_MENA."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného.

Registrace bez platby je platná maximálně $zavod_pocet_dni_na_platbu dnů, tedy do ##DatPay##. Po tomto termínu bude vaše registrace zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
$email_podpis
";


$email_registrace_platba_text_admin_resend="Dobrý den,

zaregistroval(a) jste se na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

V souladu s pravidly registrace Vás žádáme o zaslání registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$banka_ucet."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$banka_ucet_CASTKA." ".$banka_ucet_MENA."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného.

Registrace bez platby je platná maximálně $zavod_pocet_dni_na_platbu dnů, tedy do ##DatPay##. Po tomto termínu bude vaše registrace zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
$email_podpis
";


$email_registrace_bez_platby_text="Dobrý den,

zaregistroval(a) jste se na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

Protože jste se zaregistroval(a) do Prematche nebo jako rozhodčí/pomocník, nemusíte v souladu s pravidly registrace platit registrační poplatek :)

Počkejte na potvrzení registrace pořadatelem.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
$email_podpis
";

$email_registrace_cekatel_text="Dobrý den,

zaregistroval(a) jste se jako čekatel na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

Počkejte na uvolnění místa a zaslání podkladů pro platbu.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa'>$web_adresa/</a>

S pozdravem
$email_podpis
";

$email_registrace_platba_text_admin="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

V souladu s pravidly registrace Vás žádáme o zaslání registračního poplatku (neplatí pro organizátory a RO):
&nbsp;- účet: ".$banka_ucet."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$banka_ucet_CASTKA." ".$banka_ucet_MENA."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

Potvrďte svojí účast v závodu zaplacením startovného.

Registrace bez platby je platná maximálně $zavod_pocet_dni_na_platbu dnů, tedy do ##DatPay##. Po tomto termínu bude vaše registrace zrušena.

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
$email_podpis
";

$email_registrace_bez_platby_text_admin="Dobrý den,

pořadatel závodu vás zaregistroval na závod <strong>$zavod</strong>.
Datum závodu: $zavod_datum.

##STRELEC##

Protože pomáháte při závodu nebo se jakýmkoliv jiným způsobem účastníte její organizace, nemusíte platit registrační poplatek :).

Nemůžete-li se z nějakých důvodů zůčastnit závodu, neprodleně nás informujte v odpovědi na tento email nebo kliněte na odkaz <b>\"zrušit účast\"</b> vedle svého jména. Uvolníte tak místo dalším zájemcům.

Další informace o závodu najdete na adrese <a href='$web_adresa_admin'>$web_adresa_admin</a>

S pozdravem
$email_podpis
";


$email_urgence_platba_text="Dobrý den,

dne ##DatReg## jste se zaregistroval(a) na závod <strong>$zavod</strong>.

##STRELEC##
V souladu s pravidly registrace vyprší dnes $zavod_pocet_dni_na_platbu denní termín pro připsání platby (##DatPay##).
Pokud jste již platbu provedli, prosíme o zaslání potvrzení. Pokud nedojde k úhradě v průběhu následujících 2 dnů, bude vaše registrace vyřazena z aktuálního squadu a nahrazena jiným zájemcem z řad čekatelů.
<b>Vaše účast v závodě poté není garantová!</b> 

Údaje pro platbu
&nbsp;- účet: ".$banka_ucet."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$banka_ucet_CASTKA." ".$banka_ucet_MENA."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

S pozdravem
$email_podpis
";

$email_urgence_platba_text_admin="Dobrý den,

dne ##DatReg## jste se zaregistroval(a) na závod <strong>$zavod</strong>.

##STRELEC##
Do dnešního dne nedošlo k úhradě platby za registraci na výše uvedený závod. V souladu s pravidly registrace vyprší/vypršel $zavod_pocet_dni_na_platbu denní termín pro připsání platby ##DatPay##.
Pokud jste již platbu provedli, prosíme o zaslání potvrzení. Pokud nedojde k úhradě v průběhu následujících 2 dnů, bude vaše registrace vyřazena z aktuálního squadu a nahrazena jiným zájemcem z řad čekatelů.
<b>Vaše účast v závodě poté není garantová!</b> 

Údaje pro platbu
&nbsp;- účet: ".$banka_ucet."
&nbsp;- variabilní symbol: ##VAR_SYMBOL##
&nbsp;- částka: ".$banka_ucet_CASTKA." ".$banka_ucet_MENA."  

QR kód pro platbu v Kč:
<a href='##QR_LINK##'><img src='##QR_LINK##' /></a>

S pozdravem
$email_podpis
";


$email_text_platba="Dobrý den,

zaevidovali jsme úhradu registračního poplatku závodu <strong>$zavod</strong>. 

##STRELEC##
Těšíme se na brzkou viděnou na závodě.

S pozdravem
$email_podpis
";

$email_text_potvrzeni_admin="Dobrý den,

pořadatel závodu potvrdil vaši účast v závodu <strong>$zavod</strong>. 

##STRELEC##
Těšíme se na brzkou viděnou na závodě.

S pozdravem
$email_podpis
";

$email_text_vyrazeni_automaticke="Dobrý den,

protože ani po urgenci platby dne ##DatUrgence## nedošlo k zaplacení registračního poplatku v řádném termínu $zavod_pocet_dni_na_platbu dnů od provedení registrace (##DatReg##), byl(a) jste vyřazen(a) ze závodu <strong>$zavod</strong>.
<strong>Vaše registrace byla zrušena.</strong>

##STRELEC##

S pozdravem
$email_podpis
";

$email_text_vyrazeni_admin="Dobrý den,

pořadatel závodu vás vyřadil ze závodu <strong>$zavod</strong>. 
<strong>Vaše registrace byla zrušena.</strong>

##STRELEC##

S pozdravem
$email_podpis
";

$email_text_vyrazeni_vlastni="Dobrý den,

prostřednictvím odkazu z potvrzovacího emailu jste se vyřadil(a) ze závodu <strong>$zavod [".$zavod_misto."]</strong>. <strong>Vaše registrace byla zrušena.</strong> 
Pokud jste tuto akci neprovedli, neprodleně nás kontaktujte v odpovědi na tento email.

##STRELEC##

S pozdravem
$email_podpis
";

?>