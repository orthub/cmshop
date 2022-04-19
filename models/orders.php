<?php

require_once __DIR__ . '/database.php';

function get_order_overview_for_user(string $userId)
{
  $sql = 'SELECT `orders_id`, `user_id`, `order_date`, `status`, `delivery_address_id`
          FROM `orders`
          WHERE `user_id` = :userId
          ORDER BY `order_date` DESC';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $userId]);

  return $stmt->fetchAll();
}