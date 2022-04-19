<?php

require_once __DIR__ . '/database.php';

// suche ob die email in der datenbank existiert
function search_if_email_exists_already()
{
  $sql = 'SELECT `email` FROM `users`';
  $stmt = get_db()->query($sql);
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $res;
}

// Anlegen eines neuen Benutzers mit gehashtem passwort
function create_new_user(string $register_id, string $first_name, string $last_name, string $email, string $password, string $home)
{
  //passwort hashen
  $hash_password = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'INSERT INTO `users` 
          SET `id` = :userId,
              `first_name` = :firstName,
              `last_name` = :lastName,
              `email` = :email,
              `password` = :passwd,
              `home` = :home';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $register_id,
    ':firstName' => $first_name,
    ':lastName' => $last_name,
    ':email' => $email,
    ':passwd' => $hash_password,
    ':home' => $home
  ]);
  
  return $stmt;
}