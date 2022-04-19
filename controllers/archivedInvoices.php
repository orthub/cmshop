<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/users.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

// bei eingeloggtem benutzer werden die rechte abgefragt, wenn der benutzer kein
// administrator ist, wird wieder auf die startseite umgeleitet
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role !== 'ADMIN') {
    header('Location: ' . '/');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once __DIR__ . '/../helpers/session.php';

    $archive_id = trim(filter_input(INPUT_POST, 'archived-invoices', FILTER_SANITIZE_SPECIAL_CHARS));
    $invoices_url = '/var/www/html/storage/' . $archiveId . '/';
    $archived_invoices = [];
    
    if (is_dir($invoices_url)){
      if ($handle = opendir($invoices_url)){
        while (($invoice = readdir($handle)) !== false){
          $archived_invoices[] = $invoice;
        }
        closedir($handle);
      }
    }

    $_SESSION['archived']['invoice-url'] = '/storage/' . $archive_id . '/';
    $_SESSION['archived']['invoice'] = $archived_invoices;

    header('Location: ' . '/views/archived-invoices.php');
  }
}