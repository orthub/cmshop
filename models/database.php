<?php
require_once __DIR__ . '/../config/db_conf.php';
function get_db()
{
  static $db;
  if ($db instanceof PDO) {
    return $db;
  }

  try {
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
    $user = DB_USER;
    $password = DB_PASSWD;
    $db = new PDO($dsn, $user, $password);
  } catch (\Exception $e) {
    echo 'Überprüfen sie die einstellungen für die Datenbank';
    echo '<br />' . $e;
    exit();
  }

  return $db;
}