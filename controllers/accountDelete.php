<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../models/users.php';
    $user_id = $_SESSION['user_id'];
    $user_role = check_user_role($user_id);
    $role = $user_role['role'];
    
    $get_user = get_user_data_by_id($user_id);
    $first_name = $get_user['first_name'];
    $last_name = $get_user['last_name'];
    $email = $get_user['email'];
    $user_role = $get_user['role_id'];
    $invoice_path = $get_user['home'];
    $remove_user_id = $user_id;

    // falls jemand mit der rolle 'customer' gelöscht werden soll, werden alle daten geholt
    // die daten werden dann ins archiv verschoben und von der haupttabelle gelöscht
    if ($user_role === 'CUSTOMER') {
      $user_archive = move_user_to_archive($remove_user_id, $first_name, $last_name, $email, $user_role, $invoice_path);
      $deleted = delete_user_by_id($remove_user_id);
      if ((bool)$deleted === false) {
        $_SESSION['error']['delete-failed'] = 'Fehler beim löschen des Benutzers';
       header('Location: ' . '/views/account.php');
       exit();
      }
    
      if ((bool)$deleted) {
        unset($_SESSION['user_id']);
        header('Location: ' . '/');
        exit();
      }
    }
  
    // falls jemand der nicht die rolle 'customer' hat gelöscht werden soll, wird geprüft ob ein
    // post erstellt wurde, falls ja, wird die id vom post umgeschrieben, danach ins archiv und löschen
    if ($user_role !== 'CUSTOMER') {
      $search_posts = count_posts_from_user($remove_user_id);
      if ($search_posts > 0) {
        $change_author = change_author($remove_user_id, $new_user_id);
      }
      $user_archive = move_user_to_archive($remove_user_id, $first_name, $last_name, $email, $user_role, $invoice_path);
      $deleted = delete_user_by_id($remove_user_id);
      if ((bool)$deleted === false) {
        $_SESSION['error']['not-deleted'] = 'Konto konnte nicht gelöscht werden.<br /> Löschen sie gegebenenfalls den Warenkorb und versuchen sie es erneut';
        header('Location: ' . '/views/account.php');
        exit();
      }
    
      if ((bool)$deleted) {
        unset($_SESSION['user_id']);
        header('Location: ' . '/');
        exit();
      } 
    }
  }
}