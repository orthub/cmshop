<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/posts.php';
require_once __DIR__ . '/../models/userRights.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../helpers/session.php';

    $errors = [];
    $post_id = trim(filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_SPECIAL_CHARS));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
    $body = trim(filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS));

    if ((bool)$title === false) {
      $_SESSION['error']['post-title'] = 'Bitte einen Titel eingeben';
      $errors[] = 1;
    }

    if ((bool)$body === false) {
      $_SESSION['error']['post-body'] = 'Beschreibung darf nicht leer sein';
      $errors[] = 1;
    }

    if (count($errors) > 0) {
      header('Location: ' . '/views/editPost.php');
      exit();
    }
    
    $save_product = save_edited_post($post_id, $title, $body);

    if ($save_product) {
      $_SESSION['success']['post-edited'] = 'Post erfolgreich bearbeitet';
      unset($_SESSION['edit-product']);
      header('Location: ' . '/views/post-list.php');
      exit();
    }


  }

}