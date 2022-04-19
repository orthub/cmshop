<?php

require_once __DIR__ . '/database.php';

function get_delivery_address(string $user_id)
{
  $sql = 'SELECT `id`, `user_id`, `city`, `street`, `street_number`, `zip_code`
                                FROM `delivery_address`
                                WHERE `user_id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  $res = $stmt->fetchAll();

  return $res;
}

function save_delivery_address(string $user_id, string $city, string $street, string $street_number, string $zip_code)
{
  $sql = 'INSERT INTO `delivery_address`
                                SET `user_id` = :userId, 
                                    `city` = :city, 
                                    `street` = :street, 
                                    `street_number` = :streetNumber, 
                                    `zip_code` = :zipCode';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':userId' => $user_id,
    ':city' => $city,
    ':street' => $street,
    ':streetNumber' => $street_number,
    ':zipCode' => $zip_code,
  ]);
  $res = $stmt->fetchAll();

  return $res;
}

function delete_address_by_id(string $user_id, string $address_id)
{
  try {
    $sql = 'DELETE FROM `delivery_address`
            WHERE `id` = :addressId
            AND `user_id` = :userId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([
      ':addressId' => $address_id,
      ':userId' => $user_id
    ]);
  } catch (\Exception $e) {
    return false;
  }
  return true;
}