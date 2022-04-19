<?php
require_once __DIR__ . '/../helpers/session.php';


if (isset($_SESSION['error'])) {
  unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];
  $email_exist = false;
  $match_password = false;
  $login_email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $login_password = trim(filter_input(INPUT_POST, 'passwd'));

  if ((bool)$login_email === false) {
    $_SESSION['error']['login-mail'] = 'Bitte Email eingeben';
    $errors[] = 1;
  }
  if ((bool)$login_password === false) {
    $_SESSION['error']['login-passwd'] = 'Bitte Passwort eingeben';
    $errors[] = 1;
  }

  if ((bool)$login_email) {
    $_SESSION['login']['email'] = $login_email;
  }
  if ((bool)$login_password) {
    $_SESSION['login']['passwd'] = $login_password;
  }

  if (count($errors) > 0) {
    header('Location: ' . '/views/login.php');
  }

  if (count($errors) === 0) {
    require_once __DIR__ . '/../models/login.php';
    
    $email_exist = search_mail($login_email, $login_password);

    if ((bool)$email_exist === false) {
      $_SESSION['error']['login-fail'] = 'Email oder Passwort stimmt nicht';
      $errors[] = 1;
    }
    
    if (count($errors) > 0) {
      header('Location: ' . '/views/login.php');
    }

    if ((bool)$email_exist) {
      $match = get_password_from_email($login_email);
      $is_valid_login = password_verify($login_password, $match);
      
      if (!$is_valid_login) {
        $_SESSION['error']['login-fail'] = 'Email oder Passwort stimmt nicht';
        header('Location: ' . '/views/login.php');
      }
  
      if ($is_valid_login) {
        $user_id = get_user_id($login_email);
        $_SESSION['user_id'] = $user_id;
        unset($_SESSION['login']);
        header('Location: ' . '/views/main.php');
        exit();
      }
    }
  }
}