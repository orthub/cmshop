<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    require_once __DIR__ . '/../models/addresses.php';

    $address_id = filter_input(INPUT_POST, 'delete-address', FILTER_SANITIZE_SPECIAL_CHARS);

    $delete_address = delete_address_by_id($user_id, $address_id);

    if ((bool)$delete_address === false) {
      $_SESSION['error']['delete-address-fail'] = 'Adresse konnte nicht gelöscht werden';
      header('Location: ' . '/views/account.php');
      exit();
    }
    
    if ((bool)$delete_address === true) {
      $_SESSION['success']['address-deleted'] = 'Adresse wurde erfolgreich gelöscht';
      header('Location: ' . '/views/account.php');
      exit();
    }
  }
}