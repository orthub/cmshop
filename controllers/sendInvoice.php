<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

require_once __DIR__ . '/../lib/vendor/autoload.php';
require_once __DIR__ . '/../config/mail_data.php';
require_once __DIR__ . '/../helpers/sendMail.php';
require_once __DIR__ . '/../models/invoice.php';

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['order_id'];
$user_email = get_user_data_by_id($user_id);

$root_path = $_SERVER['DOCUMENT_ROOT'];
$file = '/storage/' . $user_id . '/' . $order_id . '.pdf';
$file_path = $root_path . $file;

$order_date = date('d.m.Y');

if (file_exists($file_path)) {

  $message = new Swift_Message('Bestellung vom ' . $order_date);
  $message->setBody('Danke für ihre Bestellung, die Rechnung finden sie im Anhang.');
  $message->attach(Swift_Attachment::fromPath($file_path));
  $message->setTo($user_email['email']);
  $message->setFrom([MAIL_NOREPLY => 'Stiftl | Rechnung']);
  $send = send_mail($message);
}

if (!file_exists($file_path)) {
  $_SESSION['error']['send-invoice-email'] = 'Fehler beim versenden der Email, bitte wenden sie sich an unser personal';
  header('Location: ' . '/views/thankyou.php');
}