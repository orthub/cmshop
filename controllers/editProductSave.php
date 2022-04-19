<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../models/userRights.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../helpers/session.php';

    $product_id = trim(filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_SPECIAL_CHARS));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    $price = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS));
    $quantity = trim(filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS));
    $status = trim(filter_input(INPUT_POST, 'productStatus', FILTER_SANITIZE_SPECIAL_CHARS));

    $save_product = save_edited_product($product_id, $title, $description, $price, $category_id, $quantity, $status);

    if ($save_product) {
      unset($_SESSION['edit-product']);
      header('Location: ' . '/views/product-list.php');
    }


  }

}