<?php
require_once __DIR__ . '/../helpers/session.php';

require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/userRights.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../helpers/session.php';
    $errors = [];
    $title = trim(filter_input(INPUT_POST, 'new-title', FILTER_SANITIZE_SPECIAL_CHARS));
    $body = trim(filter_input(INPUT_POST, 'new-body', FILTER_SANITIZE_SPECIAL_CHARS));

    if ((bool)$title === false) {
      $_SESSION['error']['title'] = 'Titel darf nicht leer sein';
      $errors[] = 1;
    }
    if ((bool)$body === false) {
      $_SESSION['error']['body'] = 'Post darf nicht leer sein';
      $errors[] = 1;
    }
    
    if ((bool)$title) {
      $_SESSION['newPost']['title'] = $title;
    }
    if ((bool)$body) {
      $_SESSION['newPost']['body'] = $body;
    }
    
    if (count($errors) > 0) {
      header('Location: ' . '/views/newPost.php');
    }
    
    if (count($errors) === 0) {
      require_once __DIR__ . '/../models/posts.php';

    }

    $create_new_post = new_post($title, $body, $user_id);

    if ($create_new_post){
      $_SESSION['new-post'] = 'Neuer Post wurde erfolgreich erstellt';
      unset($_SESSION['error']);
      unset($_SESSION['newPost']);
      header('Location: ' . '/views/posts.php');
    }

  }
  

}