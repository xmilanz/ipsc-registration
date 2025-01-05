<?php
/*
  JUMBO 26.10.2017
  podpůrné funkce
*/

if ((include 'phpmailer/PHPMailerAutoload.php')===false) {
  if ((include '../phpmailer/PHPMailerAutoload.php')===false) {
  }
}

function email($from_text,$from,$to, $subject = '', $message = '', $headers = '') {
  global $smtp_username,$smtp_password,$smtp_server;
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
  $mail->Host = $smtp_server;
  //Set the SMTP port number - likely to be 25, 465 or 587
  $mail->Port = 25;
  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;
  //Username to use for SMTP authentication
  $mail->Username = $smtp_username;
  //Password to use for SMTP authentication
  $mail->Password = $smtp_password;
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

?>