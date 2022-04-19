<?php
require_once __DIR__ . '/database.php';


function get_order_with_user_and_order_id(string $user_id, string $order_id)
{
  $sql = 'SELECT `orders_id`,`delivery_address_id`,`user_id`, `order_date`, `status`, `order_price`
          FROM `orders`
          WHERE `user_id` = :userId
          AND `orders_id` = :orderId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':orderId' => $order_id
  ]);
  $res = $stmt->fetch(PDO::FETCH_ASSOC);
  
  return $res;
}

function get_products_for_order(string $order_id)
{
  $sql = 'SELECT `order_id`, `product_id`, `quantity`
          FROM `order_products`
          WHERE `order_id` = :order_id';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':order_id' => $order_id]);
  $res = $stmt->fetchAll();
  
  return $res;
}

function get_product_order_info(int $product_id)
{
  $sql = 'SELECT `price`, `title`
          FROM `products` 
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':productId' => $product_id]);
  $res = $stmt->fetch(PDO::FETCH_ASSOC);
  
  return $res;
}

function get_user_data_by_id(string $user_id)
{
  $sql = 'SELECT `id`, `email`, `first_name`, `last_name`
          FROM `users`
          WHERE `id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetch(PDO::FETCH_ASSOC);

  return $res;
}

function get_delivery_address_for_order(string $user_id, string $delivery_id)
{
  $sql = 'SELECT `id`, `city`, `street`, `street_number`, `zip_code`
          FROM `delivery_address`
          WHERE `id` = :deliveryId
          AND `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':deliveryId' => $delivery_id,
    ':userId' => $user_id
  ]);
  $res = $stmt->fetch(PDO::FETCH_ASSOC);

  return $res;
}