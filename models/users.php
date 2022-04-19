<?php

require_once __DIR__ . '/database.php';


function get_all_users()
{
  $sql = 'SELECT `users`.`id`, `first_name`, `last_name`, `email`, `role_id`, `user_role`.`role`
          FROM `users`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`)';
  $stmt = get_db()->query($sql, PDO::FETCH_ASSOC);
  
  return $stmt;
}

function get_all_roles()
{
  $sql = 'SELECT `id`, `role` 
          FROM `user_role` 
          ORDER BY `role` DESC';
  $stmt = get_db()->query($sql);
  $res = $stmt->fetchAll();
  
  return $res;
}

function get_user_email_by_id(string $user_id)
{
  $sql = 'SELECT `email` FROM `users` WHERE `id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchColumn();

  return $res;
}

function get_user_data_by_id(string $user_id)
{
  $sql = 'SELECT `users`.`id`, `first_name`, `last_name`, `email`, `role_id`, `home`, `user_role`.`role`
          FROM `users`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`)
          WHERE `users`.`id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetch();

  return $res;
}

function move_user_to_archive(string $user_id, string $first_name, string $last_name, string $email, string $role_id, string $invoice_path)
{
  $sql = 'INSERT INTO `users_archive`
          SET `id` = :userId, `first_name` = :firstName, `last_name` = :lastName,
               `email` = :email, `role_id` = :roleId, `invoice_path` = :invoicePath';
  $stmt= get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':firstName' => $first_name,
    ':lastName' => $last_name,
    ':email' => $email,
    ':roleId' => $role_id,
    ':invoicePath' => $invoice_path
  ]);
}

function delete_user_by_id(string $user_id)
{
  try {
    $sql = 'DELETE FROM `users` WHERE `id` = :userId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':userId' => $user_id]);
  } catch (\Exception $e) {
    return false;
  }
  return true;
}

function count_posts_from_user(string $user_id)
{
  $sql = 'SELECT COUNT(`author`)
          FROM `posts`
          WHERE `author` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchColumn();

  return $res;
}

function change_author(string $old_author, string $new_author)
{
  $sql = 'UPDATE `posts`
          SET `author` = :newAuthor
          WHERE `author` = :oldAuthor';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':oldAuthor' => $old_author,
    ':newAuthor' => $new_author
  ]);

  return $stmt;
}

function get_archived_users()
{
  $sql = 'SELECT `users_archive`.`id`, `first_name`, `last_name`, `email`, 
                 `role_id`, `invoice_path`, `user_role`.`role`
          FROM `users_archive`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`)';
  $stmt = get_db()->query($sql, PDO::FETCH_ASSOC);

  return $stmt;
}

function get_current_password_by_id(string $user_id)
{
  $sql = 'SELECT `password`
          FROM `users`
          WHERE `id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchColumn();

  return $res;
}

function set_new_password_by_id(string $user_id, string $new_password)
{
  $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
  try {
    $sql = 'UPDATE `users`
            SET `password` = :newPassword
            WHERE `id` = :userId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([
      ':newPassword' => $hash_password,
      ':userId' => $user_id
    ]);
  } catch (\Exception $e) {
    return false;
  }
  return true;
}