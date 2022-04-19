<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/contact.php';
require_once __DIR__ . '/../models/userRights.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role === 'ADMIN') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      require_once __DIR__ . '/../helpers/session.php';
      
      $get_message_id = trim(filter_input(INPUT_POST, 'delete-message', FILTER_SANITIZE_SPECIAL_CHARS));
      if (empty($get_message_id)){
        header('Location: ' . '/views/message-list.php');
        exit();
      }
      
      $delete_message = delete_message_by_id($get_message_id);
    

      if ($delete_message) {
        $_SESSION['success']['message-deleted'] = 'Nachricht wurde erfolgreich gelöscht';
        header('Location: ' . '/views/message-list.php');
        exit();
      }
    }
    header('Location: ' . '/');
  }
  header('Location: ' . '/');
}