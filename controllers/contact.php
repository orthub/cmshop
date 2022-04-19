<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  $errors = [];
  $contact_email = trim(htmlspecialchars(filter_input(INPUT_POST, 'contact-email', FILTER_SANITIZE_EMAIL)));
  $contact_title = trim(filter_input(INPUT_POST, 'contact-title', FILTER_SANITIZE_SPECIAL_CHARS));
  $contact_message = trim(filter_input(INPUT_POST, 'contact-message', FILTER_SANITIZE_SPECIAL_CHARS));
  $contact_spam = trim(htmlspecialchars(filter_input(INPUT_POST, 'contact-spam', FILTER_SANITIZE_NUMBER_INT)));
   
  $result_spam = $_SESSION['contact']['result'];

  if ((bool)$contact_email === false) {
    $_SESSION['error']['contact-email'] = 'Bitte eine Email-Adresse angeben';
    $errors[] = 1;
  }
  if ((bool)$contact_title === false) {
    $_SESSION['error']['contact-title'] = 'Bitte einen Titel angeben';
    $errors[] = 1;
  }
  if ((bool)$contact_message === false) {
    $_SESSION['error']['contact-message'] = 'Bittte eine Nachricht angeben';
    $errors[] = 1;
  }
  if ((bool)$contact_spam === false) {
    $_SESSION['error']['contact-spam'] = 'Bittte lösen Sie die Rechenaufgabe';
    $errors[] = 1;
  }

  $_SESSION['contact']['email'] = $contact_email;
  $_SESSION['contact']['title'] = $contact_title;
  $_SESSION['contact']['message'] = $contact_message;

  if (count($errors) > 0) {
    header('Location: ' . '/views/contact.php');
    exit();
  }

  intval($contact_spam, 10);
  if ((int)$contact_spam !== (int)$result_spam) {
    $_SESSION['error']['spam-fail'] = 'Bitte lösen Sie die Rechenaufgabe noch einmal';
    $errors[] = 1;
  }

  if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error']['no-email'] = 'Bitte eine gültige Email angeben';
    $errors[] = 1;
  }

  if (count($errors) > 0) {
    header('Location: ' . '/views/contact.php');
    exit();
  }

  if (count($errors) === 0) {
    require_once __DIR__ . '/../models/contact.php';
    $create_message = create_message($contact_email, $contact_title, $contact_message);

    if ($create_message) {
      $_SESSION['success']['contact-message'] = 'Nachricht erfolgreich gesendet';
      unset($_SESSION['contact']);
      header('Location: ' . '/views/contact.php');
      exit();
    }
  }

}