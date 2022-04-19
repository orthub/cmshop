<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/contact.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if($role === 'CUSTOMER') {
    header('Location: ' . '/');
  }
  
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: ' . '/');
  }

  $message_id = trim(filter_input(INPUT_POST, 'message-id', FILTER_SANITIZE_SPECIAL_CHARS));
  $new_status_id = trim(filter_input(INPUT_POST, 'message-status', FILTER_SANITIZE_SPECIAL_CHARS));

  $new_status = change_message_status($message_id, $new_status_id);

  $set_new_status = get_new_status_from_message($message_id);
  $_SESSION['edit-message']['status'] = $set_new_status['status'];
  
  header('Location: ' . '/views/editMessage.php');
}