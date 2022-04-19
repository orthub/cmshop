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

  $post_id = trim(filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_SPECIAL_CHARS));
  $post_status = trim(filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS));
  
  if ($post_status === 'LIVE'){
    $new_status = 'DRAFT';
    $change_post_status = change_post_status_by_id($post_id, $new_status);
    if ($change_post_status) {
      $_SESSION['edit-post']['published'] = 'DRAFT';
      header('Location: ' . '/views/editPost.php');
      exit();
    }
  }
  
  if ($post_status === 'DRAFT') {
    $new_status = 'LIVE';
    $change_post_status = change_post_status_by_id($post_id, $new_status);
    if ($change_post_status) {
      $_SESSION['edit-post']['published'] = 'LIVE';
      header('Location: ' . '/views/editPost.php');
      exit();
    }
  }
  
  } else {
    header('Location: ' . '/');
}