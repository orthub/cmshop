<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  
    $errors = [];
    $current_password = trim(filter_input(INPUT_POST, 'current-pw', FILTER_SANITIZE_SPECIAL_CHARS));
    $new_password = trim(filter_input(INPUT_POST, 'new-pw', FILTER_SANITIZE_SPECIAL_CHARS));
    $confirm_password = trim(filter_input(INPUT_POST, 'confirm-pw', FILTER_SANITIZE_SPECIAL_CHARS));

    if ((bool)$current_password === false) {
      $_SESSION['error']['account-current-passwd'] = 'Bitte ihr aktuelles Passwort eingeben';
      $errors[] = 1;
    }
    if ((bool)$new_password === false) {
      $_SESSION['error']['account-new-passwd'] = 'Bitte ein neues Passwort eingeben';
      $errors[] = 1;
    }
    if ((bool)$confirm_password === false) {
      $_SESSION['error']['account-confirm-passwd'] = 'Bitte das neue Passwort bestätigen';
      $errors[] = 1;
    }

    $_SESSION['account']['cur-pw'] = $current_password;
    $_SESSION['account']['new-pw'] = $new_password;
    $_SESSION['account']['conf-pw'] = $confirm_password;
  
    if (count($errors) > 0) {
      header('Location: ' . '/views/account.php');
    }
  
    if (count($errors) === 0) {
      require_once __DIR__ . '/../models/users.php';
      $get_current_password = get_current_password_by_id($user_id);
      $check_password = password_hash($current_password, PASSWORD_DEFAULT);

      if (password_verify($check_password, $get_current_password)) {
        $_SESSION['error']['check-failed'] = 'Falsches Passwort';
        $errors[] = 1;
      }

      if (count($errors) > 0) {
        header('Location: ' . '/views/account.php');
      }

      if (count($errors) === 0){
        
        if (mb_strlen($new_password) < 8) {
          $_SESSION['error']['new-password-length'] = 'Passwort muss mindestens 8 Zeichen lang sein';
          $errors[] = 1;
        }
        
        if (count($errors) > 0) {
          header('Location: ' . '/views/account.php');
        }

        if (count($errors) === 0){
          
          if ($new_password !== $confirm_password) {
            $_SESSION['error']['confirm-failed'] = 'Passwörter stimmen nicht überein';
            $errors[] = 1;
          }
          
          if (count($errors) > 0) {
            header('Location: ' . '/views/account.php');
          }
          $set_new_password = set_new_password_by_id($user_id, $new_password);

          if ((bool)$set_new_password === false) {
            $_SESSION['error']['new-password'] = 'Passwort konnte nicht geändert werden';
            $errors[] = 1;
          }

          if (count($errors) > 0) {
            header('Location: ' . '/views/account.php');
          }

          if ((bool)$set_new_password) {
            $_SESSION['success']['new-password'] = 'Passwort wurde erfolgreich geändert';
            header('Location: ' . '/views/account.php');
            unset($_SESSION['account']);
            exit();
          }
        }
      }

    }

  }
}