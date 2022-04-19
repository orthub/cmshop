<?php

require_once __DIR__ . '/database.php';

function add_to_cart(string $user_id, string $product_id, string $quantity): bool
{
  $sql = 'INSERT INTO `cart`
          SET quantity = 1, `user_id` = :userId , `product_id` = :productId
          ON DUPLICATE KEY UPDATE quantity = quantity + :quantity';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':productId' => $product_id,
    ':quantity' => $quantity
  ]);
  remove_quantity_from_product($product_id);
  
  if ($stmt === false) {
    return false;
  }

  return true;
}

function remove_quantity_from_product(string $product_id)
{
  $sql = 'UPDATE `products` 
          SET `quantity` = `quantity` -1 
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':productId' => $product_id]);
  
  return $stmt;
}

function get_cart_products_for_user(string $user_id)
{
  $sql = 'SELECT `product_id`, `cart`.`quantity`, `title`, `price`
          FROM `cart`
          JOIN `products` ON(cart.product_id = products.id)
          WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchAll();

  return $res;
}

function remove_product_from_cart(string $user_id, string $product_id, string $quantity)
{
  $sql = 'DELETE FROM `cart`
          WHERE `product_id` = :productId
          AND `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':productId' => $product_id,
    ':userId' => $user_id
  ]);
  restore_product_quantity_from_cart($quantity, $product_id);
}

function get_quantity_from_cart(string $product_id)
{
  $sql = 'SELECT `quantity` 
          FROM `cart` 
          WHERE `product_id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':productId' => $product_id]);
  $res = $stmt->fetchColumn();

  return $res;
}

function restore_product_quantity_from_cart(string $quantity, string $product_id)
{
  $sql = 'UPDATE `products` 
          SET `quantity` = `quantity` + :quantity
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':quantity' => $quantity,
    ':productId' => $product_id
  ]);
}

function count_products_for_user($user_id)
{
  $sql = 'SELECT SUM(`quantity`)
          FROM `cart`
          WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchColumn();
  
  return $res;
}