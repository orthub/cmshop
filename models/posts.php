<?php

require_once __DIR__ . '/database.php';
/**
 * Get the last 5 posts from database
 * Post preview (body) limited to 360 chars
 */
function get_last_ten_posts()
{
  $sql = 'SELECT `posts`.`id`, `title`, SUBSTRING(`body`, 1, 360) 
          AS `body`, `author`, `created`, `first_name`, `published`
          FROM `posts`
          JOIN `users` ON(`author` = `users`.`id`)
          ORDER BY `created` DESC
          LIMIT 10';
  $res = get_db()->query($sql);
  
  return $res->fetchAll();
}

/**
 * Call the function with the give post id and return the whole post
 */
function get_post_by_id(string $post_id)
{
  $sql = 'SELECT `posts`.`id`, `title`, `body`, `author`, `created`, `first_name`, `published`
          FROM `posts`
          JOIN `users` ON(`author` = `users`.`id`)
          WHERE `posts`.`id` = :postId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([':postId' => $post_id]);
  $res = $stmt->fetch();
  
  return $res;
}

function new_post(string $title, string $body, string $user_id)
{
  $sql = 'INSERT INTO `posts`
          SET `title` = :title, 
              `body` = :body, 
              `author` = :userId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':title' => $title,
    ':body' => $body,
    ':userId' => $user_id
  ]);

  return $stmt;
}

function delete_post_by_id(string $post_id)
{
  try {
    $sql = 'DELETE FROM `posts` 
            WHERE `id` = :postId';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':postId' => $post_id]);
  } catch (\Exception $e) {
    return false;
  }

  return true;
}

function change_post_status_by_id(string $post_id, string $status)
{
  $sql = 'UPDATE `posts`
          SET `published` = :postStatus
          WHERE `id` = :postId';
$stmt = get_db()->prepare($sql);
$stmt->execute([
':postId' => $post_id,
':postStatus' => $status
]);

return $stmt;
}

function save_edited_post(string $post_id, string $title, string $body)
{
  $sql = 'UPDATE `posts`
          SET `title` = :postTitle,
              `body` = :postBody
          WHERE `id` = :postId';
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':postTitle' => $title,
    ':postBody' => $body,
    ':postId' => $post_id
  ]);

  return $stmt;
}

function get_all_posts()
{
  $sql = 'SELECT `posts`.`id`, `title`, SUBSTRING(`body`, 1, 50) 
          AS `body`, `author`, `created`, `first_name`, `published`
          FROM `posts`
          JOIN `users` ON(`author` = `users`.`id`)
          ORDER BY `created` DESC';
  $res = get_db()->query($sql);
  
  return $res->fetchAll();
}