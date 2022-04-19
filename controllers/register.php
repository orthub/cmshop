<?php
require_once __DIR__ . '/../helpers/session.php';

if (isset($_SESSION['error'])) {
  unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/register.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  $errors = [];
  $email_exists_in_database = true;
  $register_firstname = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $register_lastname = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $register_email = trim(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
  $register_password = trim(filter_input(INPUT_POST, 'passwd'));
  $register_password_confirm = trim(filter_input(INPUT_POST, 'confirm_passwd'));
  
  if((bool)$register_firstname === false) {
    $_SESSION['error']['register-firstname'] = 'Bitte Vornamen eingeben';
    $errors[] = 1;
  }
  if((bool)$register_lastname === false) {
    $_SESSION['error']['register-lastname'] = 'Bitte Nachnamen eingeben';
    $errors[] = 1;
  }
  if((bool)$register_email === false) {
    $_SESSION['error']['register-email'] = 'Bitte Email eingeben';
    $errors[] = 1;
  }
  if((bool)$register_password === false) {
    $_SESSION['error']['register-password'] = 'Bitte Passwort eingeben';
    $errors[] = 1;
  }
  if((bool)$register_password_confirm === false) {
    $_SESSION['error']['register-password-confirm'] = 'Bestätigen sie ihr Passwort';
    $errors[] = 1;
  }

  if ((bool)$register_firstname) {
    $_SESSION['registerFirstname'] = $register_firstname;
  }
  if ((bool)$register_lastname) {
    $_SESSION['registerLastname'] = $register_lastname;
  }
  if ((bool)$register_email) {
    $_SESSION['registerEmail'] = $register_email;
  }
  if ((bool)$register_password) {
    $_SESSION['registerPassword'] = $register_password;
  }
  
  if (count($errors) > 0) {
    header('Location: ' . '/views/register.php');
  }
  
  if (count($errors) === 0) {
    if (mb_strlen($register_password) < 8) {
      $_SESSION['error']['register-password-length'] = 'Passwort muss mindestens 8 Zeichen lang sein';
      $errors[] = 1;
    }
    if ($register_password != $register_password_confirm) {
      $_SESSION['error']['password-not-confirmed'] = 'Passwörter stimmen nicht überein';
      $errors[] = 1;
    }
    
    if (count($errors) > 0) {
      header('Location: ' . '/views/register.php');
    }
    
    if (count($errors) === 0) {
      
      require_once __DIR__ . '/../models/register.php';
      
      $email_exists_already = search_if_email_exists_already();
      
      foreach ($email_exists_already as $email) {
        if ($email['email'] === $register_email) {
          $email_exists_in_database = true;
          $_SESSION['error']['can-not-use-email'] = 'Email kann nicht verwendet werden';
          $errors[] = 1;
        }
      }
      if (count($errors) > 0) {
        header('Location: ' . '/views/register.php');
      }

      if (count($errors) === 0) {
        $time = microtime(true);
        $register_id = str_replace('.', '', $time);
        $register_home = '/storage/' . $register_id . '/';
        $_SESSION['register']['id'] = $register_id;
        $_SESSION['register']['first-name'] = $register_firstname;
        $_SESSION['register']['last-name'] = $register_lastname;
        $_SESSION['register']['email'] = $register_email;
        $_SESSION['register']['password'] = $register_password;
        $_SESSION['register']['home'] = $register_home;

        require_once __DIR__ . '/../controllers/confirmRegister.php';

      }  
    }
  }
}