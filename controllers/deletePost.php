<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/posts.php';
require_once __DIR__ . '/../models/userRights.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role === 'ADMIN') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      require_once __DIR__ . '/../helpers/session.php';
      
      $get_post_id = trim(filter_input(INPUT_POST, 'delete-post', FILTER_SANITIZE_SPECIAL_CHARS));
      $delete_post = delete_post_by_id($get_post_id);
    

      if ($delete_post) {
        $_SESSION['success']['post-deleted'] = 'Post wurde erfolgreich gelöscht';
        header('Location: ' . '/views/post-list.php');
        exit();
      }
    }
    header('Location: ' . '/');
  }
  header('Location: ' . '/');
}