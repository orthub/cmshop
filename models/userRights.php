<?php

require_once __DIR__ . '/database.php';

function check_user_role(string $user_id)
{
  $sql = 'SELECT `users`.`id`, `role_id`, `role`
          FROM `users`
          JOIN `user_role` ON(`role_id` = `user_role`.`id`) 
          WHERE `users`.`id` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':userId' => $user_id]);
  
  return $stmt->fetch();
}