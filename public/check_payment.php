<?php
require_once __DIR__ . '/db/dbconn.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config/mail_texty.php';

$dnes = date("d.m.Y H:i");

// 1) Načtení konfigurace závodu
$stmt = $conn->prepare("SELECT * FROM match_config WHERE Zavod_id = ?");
$stmt->bind_param("s", $table);
$stmt->execute();
$match_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($match_data['Payment_before'] == 0) {
    die();
}

// 2) Najdeme závodníky, kteří dnes měli zaplatit a nezaplatili
$sql = "SELECT * FROM `$table`
        WHERE DatPay = DATE_FORMAT(CURDATE(), '%d.%m.%Y')
        AND Squad >= 100
        AND ZaplatiNaMiste IS NULL
        AND Zaplaceno IS NULL";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die();
}

// 3) Připravíme UPDATE statement (použije se opakovaně)
$update = $conn->prepare("
    UPDATE `$table`
    SET SquadReg = ?, Squad = '-9', Vyrazeno = ?
    WHERE Alias = ?
");

// 4) Zpracujeme všechny neplatiče
while ($r = $result->fetch_assoc()) {

    $alias = $r['Alias'];
    $DatReg = date('d.m.Y', $r['DatReg']);

    // text pro email střelci
    $STRELEC  = "Datum registrace: $DatReg\r\n";
    $STRELEC .= "Termín platby: {$r['DatPay']}\r\n\r\n";
    $STRELEC .= "<b>Alias: {$r['Alias']}</b>\r\n";
    $STRELEC .= "Střelec: #{$r['Cislo']} {$r['Prijmeni']} {$r['Jmeno']}\r\n";
    $STRELEC .= "Divize: {$r['Pidiv']} {$r['Pifak']}\r\n";
    $STRELEC .= "Squad: {$r['Squad']}\r\n";

    // email střelci
    $from_text = $email_ffn;
    $from      = $match_data['Zavod_email_from'];
    $to        = $r['Mail'];
    $subject   = $match_data['Zavod'] . " - zrušení účasti";

    $message = $email_text_vyrazeni_automaticke;
    $message = str_replace("##ALIAS##",   $STRELEC, $message);
    $message = str_replace("##STRELEC##", $STRELEC, $message);
    $message = str_replace("##DatReg##",  $DatReg,  $message);
    $message = str_replace("##DatPay##",  $r['DatPay'], $message);

    email($from_text, $from, $to, $subject, $message);

    // UPDATE závodníka
    $update->bind_param("sss", $r['Squad'], $dnes, $alias);
    $update->execute();

    // email pořadateli
    $STRELEC  = "Datum registrace: $DatReg\r\n";
    $STRELEC .= "Termín platby: {$r['DatPay']}\r\n\r\n";
    $STRELEC .= "<b>Alias: {$r['Alias']}</b>\r\n";
    $STRELEC .= "Střelec: #{$r['Cislo']} {$r['Prijmeni']} {$r['Jmeno']}\r\n";
    $STRELEC .= "Původní squad: {$r['Squad']}\r\n\r\n";
    $STRELEC .= "Email: {$r['Mail']}\r\n";

    $to = $match_data['Zavod_email_from'];
    $subject = $match_data['Zavod'] . " - zrušení účasti";

    $msg = "Vyřazení závodníka pro nezaplacení.\r\n\r\n##STRELEC##";
    $msg = str_replace("##STRELEC##", $STRELEC, $msg);

    email($from_text, $from, $to, $subject, $msg);
}

$update->close();
?>
