/**
  *  
  * @param type $recipient
  * @param type $subject
  * @param type $message
  * @param type $attachment
  *  
  * To make this mail PEAR work, I needed to do:
  * pear install mail
  * pear install Net_SMTP
  * pear install Mail_Mime
  * 
*/

public function sendmail($recipient, $subject, $message, $attachment = '') {
require_once "Mail.php";
require_once "Mail/mime.php";
$from = "Dispatcher <server@mymailserver.com>";
$host = "smtp.mymailserver.com";
$port = "587";
$username = "mailuser";
$password = "password";

$headers = array ('From' => $from, 'To' => $recipient, 'Subject' => $subject);

if ($attachment != '') {
  $crlf = "\n";
  $mime = new Mail_mime($crlf);
  $mime->setTXTBody( $message );
  $mime->addAttachment($attachment, 'application/pdf');
  $body = $mime->get();
  $headers = $mime->headers($headers);
} else {
  $body = $message;
}

$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$smtp->send($recipient, $headers, $body);
}