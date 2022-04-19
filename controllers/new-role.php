<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/dashboard.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if($role !== 'ADMIN') {
    header('Location: ' . '/');
  }
  
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: ' . '/');
  }

  $role = $_POST['user-rights'];
  $selected_user_id = trim(filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_SPECIAL_CHARS));
  set_new_role($role, $selected_user_id);
  header('Location: ' . '/views/user-list.php');
}