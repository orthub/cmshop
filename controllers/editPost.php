<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/posts.php';
require_once __DIR__ . '/../models/userRights.php';


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../helpers/session.php';
    $post_id = trim(filter_input(INPUT_POST, 'edit-post', FILTER_SANITIZE_SPECIAL_CHARS));

    $edit_post = get_post_by_id($post_id);
    $_SESSION['edit-post'] = $edit_post;

    header('Location: ' . '/views/editPost.php');
  }

}