<?php

require_once __DIR__ . '/database.php';

function check_email_on_login(string $email)
{
  $sql = 'SELECT `email` 
          FROM `users`
          WHERE `email` = :email';
  $stmt = get_db()->prepare($sql);
  $stmt->execute(['email' => $email]);
  $res = $stmt->fetchColumn();

  return $res;
}

function check_password_on_login(string $email, string $password)
{
  $sql = 'SELECT `id` `email`, `password`
          FROM `users`
          WHERE `email` = :email
          AND `password` = :passwd';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':email' => $email,
    ':passwd' => $password
  ]);
  $res = $stmt->fetchColumn();

  return $res;
}


function get_login(string $email): array
{
  $sql = 'SELECT `id`, `email`, `password` 
          FROM `users` 
          WHERE `email` = :email';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':email' => $email]);
  $res = $stmt->fetchAll();

  return $res;
}

function get_user_name(string $user_id)
{
  $sql = 'SELECT `first_name` 
          FROM `users` 
          WHERE `id` = :id';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':id' => $user_id]);
  $res = $stmt->fetchColumn();
  
  return $res;
}

function search_mail(string $email): bool
{
  $sql = 'SELECT `email` FROM `users` WHERE `email` = :Email';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':Email' => $email]);
  $res = $stmt->fetchColumn();
  
  return $res;
}

function get_password_from_email(string $email)
{
  $sql = 'SELECT `password`
          FROM `users`
          WHERE `email` = :Email';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':Email' => $email,
  ]);
  $res = $stmt->fetchColumn();

  return $res;
}

function get_user_id(string $email)
{
  $sql = 'SELECT `id` FROM `users` WHERE `email` = :Email';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':Email' => $email]);
  $res = $stmt->fetchColumn();

  return $res;
}