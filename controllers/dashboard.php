<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/dashboard.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

// bei eingeloggtem benutzer werden die rechte abgefragt, wenn der benutzer kein
// administrator ist, wird wieder auf die startseite umgeleitet
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if($role !== 'ADMIN') {
    header('Location: ' . '/');
    exit();
  }
  $all_users = count_all_users();
  $admins = count_admins();
  $employees = count_employees();
  $customers = count_customers();
  $messages = count_all_messages();
  $new_messages = count_new_messages();
  $read_messages = count_read_messages();
  $answered_messages = count_answered_messages();
  $all_products = count_all_products();
  $products_live = count_live_products();
  $products_draft = count_draft_products();
  $posts = count_all_posts();
  $posts_live = count_live_posts();
  $posts_draft = count_draft_posts();
  $products_less_ten = get_products_less_ten_quantity();
  $archived_users = count_archived_users();
}