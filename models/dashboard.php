<?php

require_once __DIR__ . '/database.php';


function count_all_users()
{
  $sql = 'SELECT COUNT(`id`) FROM `users`';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_admins()
{
  $sql = 'SELECT COUNT(`role`) FROM `users`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`)
          WHERE `role` = "ADMIN"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_employees()
{
  $sql = 'SELECT COUNT(`role`) 
          FROM `users`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`) 
          WHERE `role` = "EMPLOYEE"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_customers()
{
  $sql = 'SELECT COUNT(`role`) 
          FROM `users` 
          JOIN `user_role` ON(`role_id` = `user_role`.`id`)
          WHERE `role` = "CUSTOMER"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_all_messages()
{
  $sql = 'SELECT COUNT(`id`) FROM `contact`';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_new_messages()
{
  $sql = 'SELECT COUNT(`id`) FROM `contact` WHERE `status_id` = 1';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_read_messages()
{
  $sql = 'SELECT COUNT(`id`) FROM `contact` WHERE `status_id` = 2';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_answered_messages()
{
  $sql = 'SELECT COUNT(`id`) FROM `contact` WHERE `status_id` = 3';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_all_products()
{
  $sql = 'SELECT COUNT(`id`) FROM `products`';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_live_products()
{
  $sql = 'SELECT COUNT(`id`) FROM `products` WHERE `status` = "LIVE"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_draft_products()
{
  $sql = 'SELECT COUNT(`id`) FROM `products` WHERE `status` = "DRAFT"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_all_posts()
{
  $sql = 'SELECT COUNT(`id`) FROM `posts`';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_live_posts()
{
  $sql = 'SELECT COUNT(`id`) FROM `posts` WHERE `published` = "LIVE"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function count_draft_posts()
{
  $sql = 'SELECT COUNT(`id`) FROM `posts` WHERE `published` = "DRAFT"';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function get_products_less_ten_quantity()
{
  $sql = 'SELECT `id`, `title`, `quantity`, `status` FROM `products` WHERE `quantity` < 10';
  $stmt = get_db()->query($sql);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function count_archived_users()
{
  $sql = 'SELECT COUNT(`id`) FROM `users_archive`';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function set_new_role(string $roleId, string $userId)
{
  $sql = 'UPDATE `users`
          SET `role_id` = :roleId
          WHERE `id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':roleId' => $roleId,
    ':userId' => $userId
  ]);

  return $stmt;
}