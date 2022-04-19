<?php
require_once __DIR__ . '/../helpers/session.php';

if (isset($_GET['actoken']) && !empty($_GET['actoken'])) {
  require_once __DIR__ . '/../helpers/session.php';
  $token = trim(filter_input(INPUT_GET, 'actoken', FILTER_SANITIZE_SPECIAL_CHARS));

  if ($_SESSION['register']['token'] === $token) {

    $register_id = $_SESSION['register']['id'];
    $register_firstname = $_SESSION['register']['first-name'];
    $register_lastname = $_SESSION['register']['last-name'];
    $register_email = $_SESSION['register']['email'];
    $register_password = $_SESSION['register']['password'];
    $register_home = $_SESSION['register']['home'];

    require_once __DIR__ . '/../models/register.php';

    $create_new_user = create_new_user($register_id, $register_firstname, $register_lastname, $register_email, $register_password, $register_home);

    if ((bool)$create_new_user) {
      $path = '/var/www/html/storage/' . $register_id;
      mkdir($path, 0700, true);
      $_SESSION['new-user'] = 'Account erfolgreich erstellt. Sie können sich nun einloggen';
      header('Location: ' . '/views/login.php');
    }
    
    $_SESSION['success']['activated'] = 'Account erfolgreich aktiviert';
    header('Location: ' . '/views/login.php');
    exit();
  }

  header('Location: ' . '/views/register.php');
}

header('Location: ' . '/');