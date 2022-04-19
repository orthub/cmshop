<?php
require_once __DIR__ . '/../helpers/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/products.php');
}

require_once __DIR__ . '/../helpers/nonUserRedirect.php';

require_once __DIR__ . '/../models/cart.php';

$user_id = $_SESSION['user_id'];
$product_id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS));
$quantity = '1';

$added_to_cart = add_to_cart($user_id, $product_id, $quantity);

if ($added_to_cart === false) {
  echo 'Nicht zum Warenkorb hinzugefügt!';
  header('Location: ' . '/views/products.php');
}

header('Location: ' . '/views/products.php');