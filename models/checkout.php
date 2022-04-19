<?php

require_once __DIR__ . '/database.php';

function get_quantity_product_from_cart(string $user_id)
{
  $sql = 'SELECT `product_id`, `quantity` 
          FROM `cart`
          WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  
  return $stmt->fetchAll();
}



function delivery_address_for_order(string $user_id, string $address_id)
{
  $sql = 'SELECT `id`, `city`, `street`, `street_number`, `zip_code`
          FROM `delivery_address`
          WHERE `id` = :addressId
          AND `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':addressId' => $address_id
  ]);

  return $stmt->fetch();
}

function username_for_order(string $user_id)
{
  $sql = 'SELECT `first_name`, `last_name`
          FROM `users`
          WHERE `id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);

  return $stmt->fetch();
}

function save_order(string $user_id, string $order_id, string $address_id, string $total_price)
{
  $sql = 'INSERT INTO `orders`
          SET `status` = "NEW",
          `user_id` = :userId,
          `orders_id` = :orderId,
          `delivery_address_id` = :addressId,
          `order_price` = :totalPrice';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':orderId' => $order_id,
    ':addressId' => $address_id,
    ':totalPrice' => $total_price
  ]);
  
  return $stmt;
}

function get_order_id_from_user(string $user_id)
{
  $sql = 'SELECT `order_id` 
          FROM `orders` 
          WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  
  return $stmt->fetchAll();
}

function save_order_products(string $user_id, string $order_id)
{
  $cart_products = get_quantity_product_from_cart($user_id);

  foreach ($cart_products as $value) {
    $sql = 'INSERT INTO `order_products`
            SET `order_id` = :orderId,
            `product_id` = :productId,
            `quantity` = :quantity';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([
      ':orderId' => $order_id,
      ':productId' => $value['product_id'],
      ':quantity' => $value['quantity']
    ]);
  }
  if ($stmt == 1) {
    return true;
  }
  return false;
}

function delete_products_from_cart(string $user_id)
{
  $sql = 'DELETE FROM `cart` 
          WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);

}