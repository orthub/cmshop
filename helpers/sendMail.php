<?php
require_once __DIR__ . '/../config/mail_data.php';

function send_mail(Swift_Message $message): bool
{
  $transport = new Swift_SmtpTransport(SMTP_HOST, SMTP_PORT, SMTP_SSL);
  $transport->setUsername(SMTP_USERNAME);
  $transport->setPassword(SMTP_PASSWORD);

  $mailer = new Swift_Mailer($transport);
  return $mailer->send($message);
}