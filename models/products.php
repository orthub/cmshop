<?php

require_once __DIR__ . '/database.php';

function get_all_live_products()
{
  $sql = 'SELECT `products`.`id`, `title`, `description`, `price`, 
          `category_id`, `img_url`, `slug`, `quantity`, `status`, `product_category`.`category` AS `cat`
          FROM `products`
          JOIN `product_category` ON(`category_id` = `product_category`.`id`)
          WHERE `status` = "LIVE"
          ORDER BY `products`.`id` ASC';
  $stmt = get_db()->query($sql, PDO::FETCH_ASSOC);

  return $stmt;
}

function get_categories()
{
  $sql = 'SELECT `id`, `category`
          FROM `product_category`';
  $stmt = get_db()->query($sql);
  $res = $stmt->fetchAll();

  return $res;
}

function get_category_by_id(string $category_id)
{
  $sql = 'SELECT `category`
          FROM `product_category`
          WHERE `id` = :categoryId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':categoryId' => $category_id]);
  $res = $stmt->fetchColumn();

  return $res;
}

function get_products_from_category(string $get_category_id): array
{
  $sql = 'SELECT `products`.`id`, `title`, `description`, `price`,
                 `category_id`, `slug`, `img_url`, `quantity`, `status`, `product_category`.`category` AS `cat`
          FROM `products`
          JOIN `product_category` ON(`category_id` = `product_category`.`id`)
          WHERE `category_id` = :getCategory';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':getCategory' => $get_category_id]);
  return $stmt->fetchAll();
}

function new_product(string $product, string $slug, string $description, string $price, string $category_id, string $quantity)
{
  $sql = 'INSERT INTO `products`
          SET `title` = :title, 
              `slug` = :slug, 
              `description` = :productDescription, 
              `price` = :price, 
              `category_id` = :categoryId, 
              `quantity` = :quantity,
              `status` = "DRAFT"';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':title' => $product,
    ':slug' => $slug,
    ':productDescription' => $description,
    ':price' => $price,
    ':categoryId' => $category_id,
    ':quantity' => $quantity
  ]);
  
  return $stmt;
}

function get_product_by_slug(string $slug)
{
  $sql = 'SELECT `products`.`id`, `title`, `slug`, `description`, `price`, 
                 `category_id`, `img_url`, `quantity`, `status`, `product_category`.`category` AS `cat`
          FROM `products`
          JOIN `product_category` ON(`category_id` = `product_category`.`id`)
          WHERE `slug` = :slug';
  $stmt= get_db()->prepare($sql);
  $stmt->execute([':slug' => $slug]);
  $res = $stmt->fetch();
  
  return $res;
}

function save_edited_product(string $product_id, string $title, string $description, string $price, string $category_id, string $quantity, string $status)
{
  $sql = 'UPDATE `products`
          SET `title` = :title, 
              `description` = :productDescription, 
              `price` = :price,
              `category_id` = :categoryId, 
              `quantity` = :quantity,
              `status` = :productStatus
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':title' => $title,
    ':productDescription' => $description,
    ':price' => $price,
    ':categoryId' => $category_id,
    ':quantity' => $quantity,
    ':productId' => $product_id,
    ':productStatus' => $status
  ]);
  
  return $stmt;
}

function delete_product_by_id(string $product_id): bool
{
  try {
    $sql = 'DELETE FROM `products` 
            WHERE `id` = :productId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':productId' => $product_id]);
  } catch (\Exception $e) {
    return false;
  }

  return true;
}

function check_slugs(string $slug)
{
  $sql = 'SELECT `slug`
          FROM `products`
          WHERE `slug` = :slug';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':slug' => $slug]);
  $res = $stmt->fetchColumn();

  return $res;
}

function change_product_status_by_id(string $product_id, string $status)
{
  $sql = 'UPDATE `products`
          SET `status` = :productStatus
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':productId' => $product_id,
    ':productStatus' => $status
  ]);
  
  return $stmt;
}

function update_product_image_by_slug(string $path, string $slug)
{
  $sql = 'UPDATE `products`
          SET `img_url` = :newPath
          WHERE `slug` = :slug';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':newPath' => $path,
    ':slug' => $slug
  ]);
  
  return $stmt;
}

function get_slug_path_by_id(string $product_id)
{
  $sql = 'SELECT `id`, `img_url`, `slug`
          FROM `products`
          WHERE `id` = :productId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':productId' => $product_id]);
  $res = $stmt->fetch();

  return $res;
}

function get_all_products()
{
  $sql = 'SELECT `products`.`id`, `title`, `description`, `price`, 
                 `category_id`, `img_url`, `slug`, `quantity`, `status`, `product_category`.`category` AS `cat`
          FROM `products`
          JOIN `product_category` ON(`category_id` = `product_category`.`id`)
          ORDER BY `products`.`id` DESC';
$stmt = get_db()->query($sql, PDO::FETCH_ASSOC);

return $stmt;
}