<?php
require_once __DIR__ . '/../helpers/session.php';
unset($_SESSION['errors']);
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  $errors = [];
  require_once __DIR__ . '/../models/addresses.php';

  $user_id = $_SESSION['user_id'];
  
  $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS));
  $street = trim(filter_input(INPUT_POST, 'street', FILTER_SANITIZE_SPECIAL_CHARS));
  $street_number = trim(filter_input(INPUT_POST, 'streetNumber', FILTER_SANITIZE_SPECIAL_CHARS));
  $zip_code = trim(filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_SPECIAL_CHARS));

  $_SESSION['address']['city'] = $city ;
  $_SESSION['address']['street'] = $street ;
  $_SESSION['address']['streetNumber'] = $street_number ;
  $_SESSION['address']['zip'] = $zip_code ;
  
  if ((bool)$city === false) {
    $_SESSION['error']['new-city'] = 'Bitte Stadt angeben';
    $errors[] = 1;
  }

  if ((bool)$street === false) {
    $_SESSION['error']['new-street'] = 'Bitte Straße angeben';
    $errors[] = 1;
  }

  if ((bool)$street_number === false) {
    $_SESSION['error']['new-streetNumber'] = 'Bitte Straßennummer angeben';
    $errors[] = 1;
  }

  if ((bool)$zip_code === false) {
    $_SESSION['error']['new-zip'] = 'Bitte Postleitzahl angeben';
    $errors[] = 1;
  }


  if (count($errors) > 0) {
    header('Location: ' . '/views/account.php');
    exit();
  }
  
  if (count($errors) === 0) {
    $new_delivery_address = save_delivery_address($user_id, $city, $street, $street_number, $zip_code);
    unset($_SESSION['addresss']);
    $_SESSION['success']['account-new-address'] = 'Neue Adresse hinzugefügt';
    header('Location: ' . '/views/account.php');
    exit();
  }
  
  header('Location: ' . '/views/account.php');
}