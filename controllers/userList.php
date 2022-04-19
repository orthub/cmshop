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
  
  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
    exit();
  }

  $all_users = get_all_users();
  $roles = get_all_roles();
}