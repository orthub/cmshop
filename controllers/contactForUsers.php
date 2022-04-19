<?php 
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/users.php';


// bei eingeloggtem benutzer wird die email automatisch angezeigt die in der datenbank ist
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $user_email = get_user_email_by_id($user_id);
  $_SESSION['contact']['user-email'] = $user_email;

}