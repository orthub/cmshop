<?php 
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

// bei eingeloggtem benutzer werden die rechte abgefragt, wenn der benutzer kein
// administrator ist, wird wieder auf die startseite umgeleitet
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = trim(filter_input(INPUT_POST, 'message-id', FILTER_SANITIZE_SPECIAL_CHARS));
    require_once __DIR__ . '/../helpers/session.php';
    require_once __DIR__ . '/../models/contact.php';
    $edit_message = get_single_message_by_id($message_id);
    $get_all_message_status = get_all_message_status();
    $_SESSION['edit-message'] = $edit_message;
    $_SESSION['edit-message']['edit-status'] = $get_all_message_status;

    header('Location: ' . '/views/editMessage.php');

  }

}