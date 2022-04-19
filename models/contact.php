<?php

require_once __DIR__ . '/database.php';

function create_message(string $email, string $title, string $message)
{
  $sql = 'INSERT INTO `contact`
          SET `title` = :contactTitle,
              `message` = :contactMessage,
              `email` = :contactEmail,
              `status_id` = 1';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':contactTitle' => $title,
    ':contactMessage' => $message,
    ':contactEmail' => $email
  ]);

  return $stmt;
}

function get_all_messages()
{
  $sql = 'SELECT `contact`.`id` AS `message_id`, `contact_status`.`id`, `title`, `status`, 
          SUBSTRING(`message`, 1, 50) AS `message`, 
          `status_id`, `created`
          FROM `contact`
          JOIN `contact_status` ON(`status_id` = `contact_status`.`id`)
          ORDER BY `created` DESC';
$res = get_db()->query($sql);

return $res->fetchAll();
}

function count_new_messages_for_userbar()
{
  $sql = 'SELECT COUNT(`id`) 
          FROM `contact` 
          WHERE `status_id` = 1';
  $stmt = get_db()->query($sql);
  return $stmt->fetchColumn();
}

function get_single_message_by_id(string $message_id)
{
  $sql = 'SELECT `contact`.`id` AS `message_id`, 
          `contact_status`.`id`, `title`, `status`, `email`,
          `message`, `status_id`, `created`
          FROM `contact`
          JOIN `contact_status` ON(`status_id` = `contact_status`.`id`)
          WHERE `contact`.`id` = :messageId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':messageId' => $message_id]);
  $res = $stmt->fetch();

  return $res;
}

function get_all_message_status()
{
  $sql = 'SELECT `id`, `status`
          FROM `contact_status`';
  $stmt = get_db()->query($sql);

  return $stmt->fetchAll();

}

function change_message_status(string $message_id, string $status)
{
  $sql = 'UPDATE `contact`
          SET `status_id` = :newStatus
          WHERE `id` = :messageId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':newStatus' => $status,
    ':messageId' => $message_id
  ]);

  return $stmt;
}

function get_new_status_from_message(string $message_id)
{
  $sql = 'SELECT `contact`.`id` AS `message_id`, 
          `contact_status`.`id`, `status`, `status_id`
          FROM `contact`
          JOIN `contact_status` ON(`status_id` = `contact_status`.`id`)
          WHERE `contact`.`id` = :messageId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':messageId' => $message_id]);
  $res = $stmt->fetch();

  return $res;
}

function delete_message_by_id(string $message_id)
{
  try {
    $sql = 'DELETE FROM `contact`
            WHERE `id` = :messageId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':messageId' => $message_id]);
  } catch (\Exception $e) {
    return false;
  }
  return true;
}