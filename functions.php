<?php
/*
  JUMBO 26.10.2017
  podpůrné funkce
*/

if ((include './phpmailer/PHPMailerAutoload.php')===false) {
  if ((include '../phpmailer/PHPMailerAutoload.php')===false) {
  }
}

function email($from_text,$from,$to, $subject = '', $message = '', $headers = '') {
  global $email_od_auth,$email_od_heslo,$email_od_smtp;
  $message = nl2br($message);
  //Create a new PHPMailer instance
  $mail = new PHPMailer;
  //Tell PHPMailer to use SMTP
  $mail->isSMTP();
  $mail->setLanguage('cs');
  $mail->CharSet = 'UTF-8';
  //Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  $mail->SMTPDebug = 0;
  //Ask for HTML-friendly debug output
  $mail->Debugoutput = 'html';
  //Set the hostname of the mail server
  $mail->Host = $email_od_smtp;
  //Set the SMTP port number - likely to be 25, 465 or 587
  $mail->Port = 25;
  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;
  //Username to use for SMTP authentication
  $mail->Username = $email_od_auth;
  //Password to use for SMTP authentication
  $mail->Password = $email_od_heslo;
  //Set who the message is to be sent from
  $mail->setFrom($from, $from_text);
  //Set an alternative reply-to address
//  $mail->addReplyTo("milan@g17.cz"); funkční reply-to
  //Set who the message is to be sent to
  $mail->addAddress($to, $to);
  //Set the subject line
  $mail->Subject = $subject;
  //Read an HTML message body from an external file, convert referenced images to embedded,
  //convert HTML into a basic plain-text alternative body
  $mail->msgHTML($message);
  //Replace the plain text body with one created manually
  //$mail->AltBody = $message;
  //Attach an image file
  //$mail->addAttachment('images/phpmailer_mini.png');
  //send the message, check for errors
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo."<hr/>";
      echo "smtp: ".$mail->Host."<br/>";
      echo "login: ".$mail->Username."<br/>";
      return false;
  } else {
      return true;
  }
}

function cislo_slovy($GET_CISLO) {
  $CISLO_TEST = $GET_CISLO;     

  $CO = array (" ", ",");   $CIM = array ("", ".");

  $CISLO_UPRAVA =  trim(str_replace($CO, $CIM, $CISLO_TEST));

  $MINUS = substr($CISLO_UPRAVA, 0, 1);
  if ( $MINUS == "-") $MINUS = "mínus ";
  else $MINUS = "";

  $CISLO_UPRAVA =  str_replace("-", "", $CISLO_UPRAVA);
  if ($CISLO_UPRAVA == "0") return "nula";

  $CISLO_ROZKLAD = explode(".", $CISLO_UPRAVA);   $CISLO_CELE = (int) $CISLO_ROZKLAD[0];

  $CISLO_CELE_POLE = str_split(strrev($CISLO_CELE), "3");

  $CISLICE_PREDCHOZI = "";   $CISLO_SLOVY = "";

  $CISLO_DELKA = count($CISLO_CELE_POLE);

  if ($CISLO_DELKA > 3) exit("<div style='font-weight: bold; color: #ff0000;'>Nejvyšší číslo pro převod: 999999999.</br>Nejvyšší číslo pro převod: -999999999.</div>");

  $CISLICE_TEXT_1 = array (" ", "jedna", "dvě", "tři", "čtyři", "pět", "šest", "sedm", "osm", "devět");  

  $CISLICE_TEXT_2 = array (" ", "deset", "dvacet", "třicet", "čtyřicet", "padesát", "šedesát", "sedmdesát", "osmdesát", "devadesát");  

  $CISLICE_TEXT_3 = array (" ", "sto", "stě", "sta", "sta", "set", "set", "set", "set", "set");   $CISLICE_TEXT_4 = array ("tisíc", "tisíc", "tisíce", "tisíce", "tisíce", "tisíc", "tisíc", "tisíc", "tisíc", "tisíc");  

  $CISLICE_TEXT_5 = array ("milión", "milión", "milióny", "milióny", "milióny", "miliónů", "miliónů", "miliónů", "miliónů", "miliónů");

  $CISLO_TEXT = "";  

  for ($i = ($CISLO_DELKA - 1); $i >= 0 ; $i--) {
    $CISLO_TMP = str_split(strrev($CISLO_CELE_POLE[$i]), "1");
    $CISLO_TEXT_TMP = "";
    for ($y = 0; $y < count($CISLO_TMP); $y++) {
      $PORADI = $y + (3 - count($CISLO_TMP));
      if ($PORADI == 0) {$CISLO_TEXT_TMP = $CISLO_TEXT_TMP . " " . $CISLICE_TEXT_1[$CISLO_TMP[$y]] . " " . $CISLICE_TEXT_3[$CISLO_TMP[$y]];}
      elseif ($PORADI == 1) {$CISLO_TEXT_TMP = $CISLO_TEXT_TMP . " " . $CISLICE_TEXT_2[$CISLO_TMP[$y]];}
      elseif  ($PORADI == 2) {$CISLO_TEXT_TMP = $CISLO_TEXT_TMP . " " . $CISLICE_TEXT_1[$CISLO_TMP[$y]]; $POSLEDNI_TMP = $CISLO_TMP[$y];}
    }
    if ($i == 0) $CISLO_TEXT .= $CISLO_TEXT_TMP;
    $POSLEDNI_TMP = substr($CISLO_CELE_POLE[$i], 0, 1);
    if ($i == 1) {
      if (substr(strrev($CISLO_CELE_POLE[$i]), -2) > 9 and substr(strrev($CISLO_CELE_POLE[$i]), -2) < 15) $POSLEDNI_TMP = 1;
      $CISLO_TEXT .= $CISLO_TEXT_TMP . " " .  $CISLICE_TEXT_4[$POSLEDNI_TMP];
    }
    if ($i == 2) {
      if (substr(strrev($CISLO_CELE_POLE[$i]), -2) > 9 and substr(strrev($CISLO_CELE_POLE[$i]), -2) < 15) $POSLEDNI_TMP = 9;
      $CISLO_TEXT .= $CISLO_TEXT_TMP . " " .  $CISLICE_TEXT_5[$POSLEDNI_TMP];
    }
  }

  $CISLO_TEXT =  preg_replace('/(\s+)/', ' ', $CISLO_TEXT);

  $CO = array("deset jedna", "deset dvě", "deset tři", "deset čtyři", "deset pět", "deset šest", "deset sedm", "deset osm", "deset devět");
  $CIM = array ("jedenáct", "dvanáct", "třináct", "čtrnáct", "patnáct", "šestnáct", "sedmnáct", "osmnáct", "devatenáct");
  $CISLO_TEXT = str_replace($CO, $CIM, $CISLO_TEXT);
  $CO = array("jedna sto", "jedna tisíc", "dvě tisíce", "jedna milión", "milión tisíc", "milióny tisíc", "miliónů tisíc");
  $CIM = array ("jedno sto", "jeden tisíc", "dva tisíce", "jeden milión", "milión", "milióny", "miliónů");
  $CISLO_TEXT = str_replace($CO, $CIM, $CISLO_TEXT);
  $CISLO_TEXT = str_replace(" ", "", $CISLO_TEXT);
  return $MINUS . $CISLO_TEXT;
}
?>